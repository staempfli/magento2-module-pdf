<?php
namespace Staempfli\Pdf\Adapter;


use Staempfli\Pdf\Api\PdfFile;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Api\TableOfContents;

final class WkPdfEngine implements PdfEngine
{
    public function addPage($html, Options $options)
    {
        // TODO: Implement addPage() method.
    }

    public function setCover($html, Options $options)
    {
        // TODO: Implement setCover() method.
    }

    public function setTableOfContents(Options $options)
    {
        // TODO: Implement setTableOfContents() method.
    }

    /**
     * @param Options $globalOptions
     * @return PdfFile
     */
    public function generatePdf(Options $globalOptions)
    {
        // TODO: Implement generatePdf() method.
        // this is the adapter to the actual PDF generating library.
        // Always use mock/fake in unit tests, only integration test for this
    }

}