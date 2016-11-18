<?php
namespace Staempfli\Pdf\Adapter;

// TODO implement
// this is the adapter to the actual PDF generating library.
// Always use mock/fake in unit tests, only integration test for this
use mikehaertl\wkhtmlto\Pdf;
use Staempfli\Pdf\Api\PdfFile;

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
        // TODO: Implement saveAs() method.
    }

    public function send()
    {
        // TODO: Implement send() method.
    }

    public function toString()
    {
        return $this->wkPdf->toString();
    }

}