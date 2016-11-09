<?php
namespace Staempfli\Pdf\Test\Unit\Api;


use Staempfli\Pdf\Api\FakePdfEngine;
use Staempfli\Pdf\Api\GeneratedPdf;
use Staempfli\Pdf\Api\NullMedium;
use Staempfli\Pdf\Api\NullToc;
use Staempfli\Pdf\Api\PdfBuilder;
use Staempfli\Pdf\Api\WkOptions;
use Staempfli\Pdf\Api\WkPdfPage;
use Staempfli\Pdf\Api\WkPdfTableOfContents;


class PdfBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var FakePdfEngine */
    private $fakePdfEngine;
    /** @var PdfBuilder */
    private $pdfBuilder;

    protected function setUp()
    {
        $this->fakePdfEngine = new FakePdfEngine();
        $this->pdfBuilder = new PdfBuilder($this->fakePdfEngine);
    }

    public function testBuildEmpty()
    {
        $this->assertFalse($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $this->assertInstanceOf(GeneratedPdf::class, $this->pdfBuilder->build());
        $this->assertTrue($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $this->assertInstanceOf(NullMedium::class, $this->fakePdfEngine->cover);
        $this->assertInstanceOf(NullToc::class, $this->fakePdfEngine->tableOfContents);
        $this->assertCount(0, $this->fakePdfEngine->pages);
    }

    public function testBuildWithContent()
    {
        $this->assertFalse($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $options = new WkOptions(['something' => 'something']);
        $tableOfContents = new WkPdfTableOfContents();
        $cover = new WkPdfPage();
        $page1 = new WkPdfPage();
        $page2 = new WkPdfPage();
        $this->pdfBuilder->setCover($cover);
        $this->pdfBuilder->setOptions($options);
        $this->pdfBuilder->setTableOfContents($tableOfContents);
        $this->pdfBuilder->addPage($page1);
        $this->pdfBuilder->addPage($page2);
        $this->assertInstanceOf(GeneratedPdf::class, $this->pdfBuilder->build());
        $this->assertTrue($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $this->assertSame([$page1, $page2], $this->fakePdfEngine->pages);
        $this->assertSame($cover, $this->fakePdfEngine->cover);
        $this->assertSame($tableOfContents, $this->fakePdfEngine->tableOfContents);
        $this->assertSame($options, $this->fakePdfEngine->globalOptions);
    }
}
