<?php
namespace Staempfli\Pdf\Api;


class FakePdfEngine implements PdfEngine
{
    /** @var FakeGeneratedPdf */
    private $fakeGeneratedPdf;

    /**
     * @param Options $globalOptions
     * @param Medium $cover
     * @param TableOfContents $toc
     * @param Medium[] ...$pages
     * @return FakeGeneratedPdf
     */
    public function generatePdf(Options $globalOptions, Medium $cover, TableOfContents $toc, Medium ...$pages)
    {
        // TODO: Implement generatePdf() method.
    }

    //TODO implement methods needed for assertions
}