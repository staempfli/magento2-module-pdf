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
use Staempfli\Pdf\Api\WkSourceDocument;


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

    public function testAddPageFromSource()
    {
        $this->pdfBuilder->addPageFromSource(new WkSourceDocument('HTML source', new WkOptions(['looks' => 'nice'])));
        $this->pdfBuilder->build();
        $this->assertEquals('HTML source', $this->fakePdfEngine->pages[0]->html());
        $this->assertEquals(new WkOptions(['looks' => 'nice']), $this->fakePdfEngine->pages[0]->options());
    }
    public function testSetCoverFromSource()
    {
        $this->pdfBuilder->setCoverFromSource(new WkSourceDocument('Cover HTML source', new WkOptions(['looks' => 'great'])));
        $this->pdfBuilder->build();
        $this->assertEquals('Cover HTML source', $this->fakePdfEngine->cover->html());
        $this->assertEquals(new WkOptions(['looks' => 'great']), $this->fakePdfEngine->cover->options());
    }
    public function testSetHeaderFromSource()
    {
        $this->pdfBuilder->setHeaderHtml('Header HTML source');
        $this->pdfBuilder->build();
        $this->assertEquals('Header HTML source', $this->fakePdfEngine->globalOptions[WkOptions::KEY_HEADER_HTML]);
    }
    public function testSetFooterFromSource()
    {
        $this->pdfBuilder->setFooterHtml('Footer HTML source');
        $this->pdfBuilder->build();
        $this->assertEquals('Footer HTML source', $this->fakePdfEngine->globalOptions[WkOptions::KEY_FOOTER_HTML]);
    }
}
