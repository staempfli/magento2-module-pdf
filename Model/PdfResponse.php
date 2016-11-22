<?php
namespace Staempfli\Pdf\Model;

use Magento\Framework\App\ResponseInterface;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\OptionsFactory as PdfOptionsFactory;
use Staempfli\Pdf\Api\SourceDocument;

final class PdfResponse implements ResponseInterface, SourceDocument
{

    private $body;
    /** @var  Options */
    private $pdfOptions;

    /**
     * PdfResponse constructor.
     */
    public function __construct(PdfOptionsFactory $optionsFactory)
    {
        //TODO decide where and how to define page specific options. Probably need to expose an addOptions() method
        $this->pdfOptions = $optionsFactory->create();
    }

    /**
     * We don't actually send a HTTP response, the PdfResponse instance is sent to the Pdf service instead
     *
     * @return void
     */
    public function sendResponse()
    {
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
     * @param Medium $medium
     */
    public function printTo(Medium $medium)
    {
        $medium->printHtml($this->body, $this->pdfOptions);
    }


}