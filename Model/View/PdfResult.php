<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Model\View;

use Magento\Framework;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\AbstractResult;
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
class PdfResult extends AbstractResult
{
    const TYPE = 'pdf';

    /**
     * @var \Staempfli\Pdf\Model\PdfResponseFactory
     */
    private $pdfResponseFactory;

    /**
     * @var \Staempfli\Pdf\Model\PdfFactory
     */
    private $pdfFactory;

    /**
     * @var \Staempfli\Pdf\Api\Options
     */
    private $pdfGlobalOptions;

    /**
     * @var \Staempfli\Pdf\Api\Options
     */
    private $pdfPageOptions;

    /**
     * @var \Staempfli\Pdf\Model\View\PageResultWithoutHttp
     */
    private $pageResult;

    /**
     * @var null|string
     */
    private $filename = null;

    /**
     * @param \Staempfli\Pdf\Model\PdfResponseFactory $pdfResponseFactory
     * @param \Staempfli\Pdf\Model\PdfFactory $pdfFactory
     * @param \Staempfli\Pdf\Api\OptionsFactory $pdfOptionsFactory
     * @param \Staempfli\Pdf\Model\View\PageResultWithoutHttp $pageResult
     */
    public function __construct(
        PdfResponseFactory $pdfResponseFactory,
        PdfFactory $pdfFactory,
        OptionsFactory $pdfOptionsFactory,
        PageResultWithoutHttp $pageResult
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
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @param \Staempfli\Pdf\Api\Options $options
     * @return $this
     */
    public function addGlobalOptions(Options $options)
    {
        $this->pdfGlobalOptions = $this->pdfGlobalOptions->merge($options);

        return $this;
    }

    /**
     * @param \Staempfli\Pdf\Api\Options $options
     * @return $this
     */
    public function addPageOptions(Options $options)
    {
        $this->pdfPageOptions = $this->pdfPageOptions->merge($options);

        return $this;
    }

    /**
     * @return \Staempfli\Pdf\Model\PdfResponse
     */
    public function renderSourceDocument()
    {
        /** @var \Staempfli\Pdf\Model\PdfResponse $pdfResponse */
        $pdfResponse = $this->pdfResponseFactory->create([
            PdfResponse::PARAM_OPTIONS => $this->pdfPageOptions,
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
     * {@inheritdoc}
     */
    protected function render(ResponseInterface $response)
    {
        $this->preparePdfResponse($response, $this->renderPdf());

        return $this;
    }

    /**
     * @param \Magento\Framework\App\Response\Http $response
     * @param string $body
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
}
