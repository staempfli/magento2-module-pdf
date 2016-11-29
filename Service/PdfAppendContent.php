<?php
namespace Staempfli\Pdf\Service;


use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;

/**
 * Medium that appends HTML page to PDF
 */
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