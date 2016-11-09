<?php
namespace Staempfli\Pdf\Api;

/**
 * Fake implementation to be used in tests
 */
class FakePdfEngine implements PdfEngine
{
    /** @var FakeGeneratedPdf */
    public $fakeGeneratedPdf;
    /**
     * @var Options
     */
    public $globalOptions;
    /**
     * @var Medium
     */
    public $cover;
    /**
     * @var TableOfContents
     */
    public $tableOfContents;
    /**
     * @var Medium[]
     */
    public $pages;

    public function __construct()
    {
        $this->fakeGeneratedPdf = new FakeGeneratedPdf();
    }

    /**
     * @param Options $globalOptions
     * @param Medium $cover
     * @param TableOfContents $toc
     * @param Medium[] ...$pages
     * @return FakeGeneratedPdf
     */
    public function generatePdf(Options $globalOptions, Medium $cover, TableOfContents $toc, Medium ...$pages)
    {
        $this->globalOptions = $globalOptions;
        $this->cover = $cover;
        $this->tableOfContents = $toc;
        $this->pages = $pages;
        $this->fakeGeneratedPdf->isGenerated = true;
        return $this->fakeGeneratedPdf;
    }
}