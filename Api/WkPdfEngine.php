<?php
namespace Staempfli\Pdf\Api;


final class WkPdfEngine implements PdfEngine
{
    /**
     * @param Options $globalOptions
     * @param Medium $cover
     * @param TableOfContents $toc
     * @param Medium[] ...$pages
     * @return GeneratedPdf
     */
    public function generatePdf(Options $globalOptions, Medium $cover, TableOfContents $toc, Medium ...$pages)
    {
        // TODO: Implement generatePdf() method.
        // this is the adapter to the actual PDF generating library.
        // Always use mock/fake in unit tests, only integration test for this
    }

}