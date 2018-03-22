<?php
namespace Staempfli\Pdf\Model\View;

use Magento\Framework;
use Magento\Framework\App\Response\HttpInterface as HttpResponseInterface;
use Magento\Framework\App\ResponseInterface;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\OptionsFactory;
use Staempfli\Pdf\Model\PdfFactory;
use Staempfli\Pdf\Model\PdfResponse;
use Staempfli\Pdf\Model\PdfResponseFactory;

/**
 * To render a single layout (without cover page), you can return the result instance directly from the controller.
 *
 * For more advanced options, use renderSourceDocument() to get a source document you can pass into the Pdf service
 */
class PdfResult extends Framework\Controller\AbstractResult
{
    const TYPE = 'pdf';

    /** @var PdfResponseFactory */
    private $pdfResponseFactory;
    /** @var PdfFactory */
    private $pdfFactory;
    /** @var Options */
    private $pdfGlobalOptions;
    /** @var Options */
    private $pdfPageOptions;
    /** @var PageResultWithoutHttp */
    private $pageResult;
    /** @var string */
    private $filename = null;

    public function __construct(PdfResponseFactory $pdfResponseFactory, PdfFactory $pdfFactory,
        OptionsFactory $pdfOptionsFactory, PageResultWithoutHttp $pageResult
    ) {
    
        $this->pdfResponseFactory = $pdfResponseFactory;
        $this->pdfFactory = $pdfFactory;
        $this->pdfGlobalOptions = $pdfOptionsFactory->create();
        $this->pdfPageOptions = $pdfOptionsFactory->create();
        $this->pageResult = $pageResult;
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

    public function addGlobalOptions(Options $options)
    {
        $this->pdfGlobalOptions = $this->pdfGlobalOptions->merge($options);
    }

    public function addPageOptions(Options $options)
    {
        $this->pdfPageOptions = $this->pdfPageOptions->merge($options);
    }

    /**
     * Renders directly to HTTP response
     *
     * @param HttpResponseInterface $response
     * @return $this
     */
    protected function render(HttpResponseInterface $response)
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
        $pdfResponse = $this->pdfResponseFactory->create([
            PdfResponse::PARAM_OPTIONS => $this->pdfPageOptions
        ]);
        /*
         * As of Magento 2.1, addDefaultHandle() must be called after instantiating a layout result,
         * see \Magento\Framework\Controller\ResultFactory::create()
         *
         * But since it is marked as a temporary solution, this might change in a later Magento release
         */
        $this->pageResult->addDefaultHandle();

        $this->pageResult->renderNonHttpResult($pdfResponse);
        return $pdfResponse;
    }

    /**
     * @return string
     */
    protected function renderPdf()
    {
        $pdf = $this->pdfFactory->create();
        $pdf->addOptions($this->pdfGlobalOptions);
        $pdfResponse = $this->renderSourceDocument();
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