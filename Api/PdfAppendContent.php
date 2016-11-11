<?php
namespace Staempfli\Pdf\Api;


final class PdfAppendContent implements Medium
{
    /**
     * @var PdfEngine
     */
    private $pdfEngine;

    public function __construct(PdfEngine $pdfEngine)
    {
        $this->pdfEngine = $pdfEngine;
    }

    public function printHtml($html, Options $options)
    {
        $this->pdfEngine->addPage($html, $options);
    }
}