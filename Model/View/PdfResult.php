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
use Staempfli\Pdf\Service\Pdf;

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
     * Renders directly to HTTP response
     *
     * @param Framework\App\Response\Http|ResponseInterface $response
     * @return $this
     */
    protected function render(ResponseInterface $response)
    {
        $pdf = $this->pdfFactory->create();

        // $pdf->addOptions($this->pdfGlobalOptions); //TODO implement setter or attribute for global options
        $pdfResponse = $this->renderSourceDocument();
        //$pdfResponse->addOptions($this->pdfPageOptions); //TODO implement setter or attribute for page options
        $pdf->appendContent($pdfResponse);

        $response->setHeader('Content-type', 'application/pdf', true);
        $response->appendBody($pdf->file()->toString());

        return $this;
    }

}