<?php
namespace Staempfli\Pdf\Test\Unit\Api;


use Staempfli\Pdf\Api\FakePdfEngine;
use Staempfli\Pdf\Api\GeneratedPdf;
use Staempfli\Pdf\Api\NullToc;
use Staempfli\Pdf\Api\PdfBuilder;
use Staempfli\Pdf\Api\WkOptions;
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
        $this->assertNull($this->fakePdfEngine->tableOfContents);
        $this->assertNull($this->fakePdfEngine->cover);
        $this->assertCount(0, $this->fakePdfEngine->pages);
    }

    public function testBuildWithGlobalOptions()
    {
        $this->assertFalse($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $options = new WkOptions(['something' => 'something']);
        $this->pdfBuilder->setOptions($options);

        $this->assertInstanceOf(GeneratedPdf::class, $this->pdfBuilder->build());
        $this->assertTrue($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $this->assertSame($options, $this->fakePdfEngine->globalOptions);
    }

    public function testBuildWithTableOfContents()
    {
        $this->assertFalse($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $this->pdfBuilder->setTableOfContents(new WkOptions(['toc' => 'tic']));

        $this->assertInstanceOf(GeneratedPdf::class, $this->pdfBuilder->build());
        $this->assertTrue($this->fakePdfEngine->fakeGeneratedPdf->isGenerated);
        $this->assertEquals(new WkOptions(['toc' => 'tic']), $this->fakePdfEngine->tableOfContents);
    }

    public function testAddOptions()
    {
        $this->pdfBuilder->setOptions(new WkOptions(['first-option' => 'foo', 'second-option' => 'bar']));
        $this->pdfBuilder->addOptions(new WkOptions(['third-option' => 'baz', 'first-option' => 'foo²']));
        $this->pdfBuilder->build();
        $this->assertEquals(new WkOptions(['first-option' => 'foo²', 'second-option' => 'bar', 'third-option' => 'baz']), $this->fakePdfEngine->globalOptions);
    }
    public function testAppendContent()
    {
        $this->pdfBuilder->appendContent(new WkSourceDocument('HTML source', new WkOptions(['looks' => 'nice'])));
        $this->pdfBuilder->build();
        $this->assertEquals(['HTML source', new WkOptions(['looks' => 'nice'])], $this->fakePdfEngine->pages[0]);
    }
    public function testSetCover()
    {
        $this->pdfBuilder->setCover(new WkSourceDocument('Cover HTML source', new WkOptions(['looks' => 'great'])));
        $this->pdfBuilder->build();
        $this->assertEquals(['Cover HTML source', new WkOptions(['looks' => 'great'])], $this->fakePdfEngine->cover);
    }
    public function testSetHeaderHtml()
    {
        $this->pdfBuilder->setHeaderHtml('Header HTML source');
        $this->pdfBuilder->build();
        $this->assertEquals('Header HTML source', $this->fakePdfEngine->globalOptions[WkOptions::KEY_HEADER_HTML]);
    }
    public function testSetFooterHtml()
    {
        $this->pdfBuilder->setFooterHtml('Footer HTML source');
        $this->pdfBuilder->build();
        $this->assertEquals('Footer HTML source', $this->fakePdfEngine->globalOptions[WkOptions::KEY_FOOTER_HTML]);
    }
}
