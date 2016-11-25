<?php
namespace Staempfli\Pdf\Adapter;

use mikehaertl\wkhtmlto\Pdf;
use Staempfli\Pdf\Api\PdfFile;

/**
 * This is the adapter to the actual PDF generating library.
 * Always use mock/fake in unit tests, only integration test for this
 */
final class WkPdfFile implements PdfFile
{
    /** @var Pdf */
    private $wkPdf;

    public function __construct(Pdf $wkPdf)
    {
        $this->wkPdf = $wkPdf;
    }

    public function saveAs($path)
    {
        return $this->wkPdf->saveAs($path);
    }

    public function send()
    {
        return $this->wkPdf->send();
    }

    public function toString()
    {
        //TODO if false, throw exception with $this->wkPdf->getError()
        return $this->wkPdf->toString();
    }

}