<?php
namespace Staempfli\Pdf\Model\View;

use Magento\Framework;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Result\Page as PageResult;
use Staempfli\Pdf\Model\PdfFactory;
use Staempfli\Pdf\Model\PdfResponse;
use Staempfli\Pdf\Model\PdfResponseFactory;

/**
 * To render a single layout (without cover page), you can return the result instance directly from the controller.
 *
 * For more advanced options, use renderSourceDocument() to get a source document you can pass into the Pdf service
 */
class PdfResult extends PageResult
{
    const TYPE = 'pdf';

    /** @var PdfResponseFactory */
    private $pdfResponseFactory;
    /** @var PdfFactory */
    private $pdfFactory;
    /** @var string */
    private $filename = null;

    public function __construct(PdfResponseFactory $pdfResponseFactory, PdfFactory $pdfFactory, TemplateContext $context,
                                View\LayoutFactory $layoutFactory, View\Layout\ReaderPool $layoutReaderPool,
                                Framework\Translate\InlineInterface $translateInline,
                                View\Layout\BuilderFactory $layoutBuilderFactory,
                                View\Layout\GeneratorPool $generatorPool,
                                View\Page\Config\RendererFactory $pageConfigRendererFactory,
                                View\Page\Layout\Reader $pageLayoutReader,
                                $template,
                                $isIsolated = false)
    {
        parent::__construct(
            $context, $layoutFactory, $layoutReaderPool, $translateInline, $layoutBuilderFactory,
            $generatorPool, $pageConfigRendererFactory, $pageLayoutReader, $template, $isIsolated
        );
        $this->pdfResponseFactory = $pdfResponseFactory;
        $this->pdfFactory = $pdfFactory;
    }

    /**
     * Set filename for download. If null, Content-Disposition header is not sent,
     * i.e. download will not be forced and PDF may be displayed in browser
     *
     * @param $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Renders directly to HTTP response
     *
     * @param Framework\App\Response\Http|ResponseInterface $response
     * @return $this
     */
    protected function render(ResponseInterface $response)
    {
        $this->preparePdfResponse($response, $this->renderPdf());

        return $this;
    }

    /**
     * @return PdfResponse
     */
    public function renderSourceDocument()
    {
        /** @var PdfResponse $pdfResponse */
        $pdfResponse = $this->pdfResponseFactory->create();
        parent::render($pdfResponse);
        return $pdfResponse;
    }

    /**
     * @return string
     */
    protected function renderPdf()
    {
        $pdf = $this->pdfFactory->create();
        // $pdf->addOptions($this->pdfGlobalOptions); //TODO implement setter or attribute for global options
        $pdfResponse = $this->renderSourceDocument();
        //$pdfResponse->addOptions($this->pdfPageOptions); //TODO implement setter or attribute for page options
        $pdf->appendContent($pdfResponse);
        $body = $pdf->file()->toString();
        return $body;
    }

    /**
     * @param Framework\App\Response\Http $response
     * @param $body
     * @return void
     */
    protected function preparePdfResponse(Framework\App\Response\Http $response, $body)
    {
        $response->setHeader('Content-type', 'application/pdf', true);
        $response->setHeader('Content-Length', \strlen($body));
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Last-Modified', \date('r'), true);
        if (null !== $this->filename) {
            $response->setHeader('Content-Disposition', 'attachment; filename="' . $this->filename . '"', true);
        }
        $response->appendBody($body);
    }

}