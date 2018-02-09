<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Model;

use Magento\Framework\App\ResponseInterface;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\SourceDocument;

/**
 * A Magento response,
 * used by the framework to render HTML (ResponseInterface) and by the PDF service to print it (SourceDocument).
 *
 * HTTP response must be created separately if desired
 * (the PdfResult controller result implementation can be used for this)
 */
final class PdfResponse implements ResponseInterface, SourceDocument
{
    const PARAM_OPTIONS = 'options';

    /**
     * @var string
     */
    private $body;

    /**
     * @var \Staempfli\Pdf\Api\Options
     */
    private $pdfOptions;

    /**
     * @param \Staempfli\Pdf\Api\Options $options
     */
    public function __construct(
        Options $options
    ) {
        $this->pdfOptions = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function sendResponse()
    {
        /* We don't actually send a HTTP response, the PdfResponse instance is sent to the Pdf service instead */
        return;
    }

    /**
     * Not explicitly part of the Response interface but implicitly required by \Magento\Framework\View\Result\Page
     *
     * @param string $value
     * @return $this
     */
    public function appendBody($value)
    {
        $this->body .= $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function printTo(Medium $medium)
    {
        $medium->printHtml($this->body, $this->pdfOptions);
    }
}
