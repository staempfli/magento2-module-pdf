<?php
namespace Staempfli\Pdf\Test\Unit\Service;

use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfOptions;
use Staempfli\Pdf\Service\PdfTableOfContents;

class PdfTableOfContentsTest extends \PHPUnit_Framework_TestCase
{
    /** @var FakePdfEngine */
    private $pdfEngine;
    /** @var PdfTableOfContents */
    private $tableOfContents;

    protected function setUp()
    {
        $this->pdfEngine = new \Staempfli\Pdf\Service\FakePdfEngine();
        $this->tableOfContents = new PdfTableOfContents($this->pdfEngine);
    }
    public function testPrintToc()
    {
        $this->tableOfContents->printToc(new PdfOptions(['print-option' => 'something']));
        $this->assertEquals(new PdfOptions(['print-option' => 'something']), $this->pdfEngine->tableOfContents);
    }
}
