<?php
namespace Staempfli\Pdf\Service;
use Staempfli\Pdf\Service\FakePdfFile;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;

/**
 * Fake implementation to be used in tests
 */
class FakePdfEngine implements PdfEngine
{
    /** @var FakePdfFile */
    public $fakePdfFile;
    /**
     * @var Options
     */
    public $globalOptions;
    /**
     * @var array [string, Options]
     */
    public $cover;
    /**
     * @var Options
     */
    public $tableOfContents;
    /**
     * @var array[] array of pages as [string, Options]
     */
    public $pages = [];

    public function __construct()
    {
        $this->fakePdfFile = new FakePdfFile();
    }

    public function addPage($html, Options $options)
    {
        $this->pages[] = [$html, $options];
    }

    public function addCover($html, Options $options)
    {
        $this->cover = [$html, $options];
    }

    public function addTableOfContents(Options $options)
    {
        $this->tableOfContents = $options;
    }

    /**
     * @param Options $globalOptions
     * @param Medium $cover
     * @param Medium[] ...$pages
     * @return FakePdfFile
     */
    public function generatePdf(Options $globalOptions)
    {
        $this->globalOptions = $globalOptions;
        $this->fakePdfFile->isGenerated = true;
        return $this->fakePdfFile;
    }
}