<?php
namespace Staempfli\Pdf\Test\Unit\Service;


use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Api\PdfFile;
use Staempfli\Pdf\Api\NullToc;
use Staempfli\Pdf\Service\Pdf;
use Staempfli\Pdf\Service\PdfOptions;
use Staempfli\Pdf\Service\FakeSourceDocument;


class PdfTest extends \PHPUnit_Framework_TestCase
{
    /** @var FakePdfEngine */
    private $fakePdfEngine;
    /** @var Pdf */
    private $pdf;

    protected function setUp()
    {
        $this->fakePdfEngine = new FakePdfEngine();
        $this->pdf = new Pdf($this->fakePdfEngine);
    }

    public function testBuildEmpty()
    {
        $this->assertFalse($this->fakePdfEngine->fakePdfFile->isGenerated);
        $this->assertInstanceOf(PdfFile::class, $this->pdf->file());
        $this->assertTrue($this->fakePdfEngine->fakePdfFile->isGenerated);
        $this->assertNull($this->fakePdfEngine->tableOfContents);
        $this->assertNull($this->fakePdfEngine->cover);
        $this->assertCount(0, $this->fakePdfEngine->pages);
    }

    public function testBuildWithGlobalOptions()
    {
        $this->assertFalse($this->fakePdfEngine->fakePdfFile->isGenerated);
        $options = new PdfOptions(['something' => 'something']);
        $this->pdf->setOptions($options);

        $this->assertInstanceOf(PdfFile::class, $this->pdf->file());
        $this->assertTrue($this->fakePdfEngine->fakePdfFile->isGenerated);
        $this->assertSame($options, $this->fakePdfEngine->globalOptions);
    }

    public function testBuildWithTableOfContents()
    {
        $this->assertFalse($this->fakePdfEngine->fakePdfFile->isGenerated);
        $this->pdf->appendTableOfContents(new PdfOptions(['toc' => 'tic']));

        $this->assertInstanceOf(PdfFile::class, $this->pdf->file());
        $this->assertTrue($this->fakePdfEngine->fakePdfFile->isGenerated);
        $this->assertEquals(new PdfOptions(['toc' => 'tic']), $this->fakePdfEngine->tableOfContents);
    }

    public function testAddOptions()
    {
        $this->pdf->setOptions(new PdfOptions(['first-option' => 'foo', 'second-option' => 'bar']));
        $this->pdf->addOptions(new PdfOptions(['third-option' => 'baz', 'first-option' => 'foo²']));
        $this->pdf->file();
        $this->assertEquals(new PdfOptions(['first-option' => 'foo²', 'second-option' => 'bar', 'third-option' => 'baz']), $this->fakePdfEngine->globalOptions);
    }
    public function testAppendContent()
    {
        $this->pdf->appendContent(new FakeSourceDocument('HTML source', new PdfOptions(['looks' => 'nice'])));
        $this->pdf->file();
        $this->assertEquals(['HTML source', new PdfOptions(['looks' => 'nice'])], $this->fakePdfEngine->pages[0]);
    }
    public function testSetCover()
    {
        $this->pdf->appendCover(new FakeSourceDocument('Cover HTML source', new PdfOptions(['looks' => 'great'])));
        $this->pdf->file();
        $this->assertEquals(['Cover HTML source', new PdfOptions(['looks' => 'great'])], $this->fakePdfEngine->cover);
    }
}
