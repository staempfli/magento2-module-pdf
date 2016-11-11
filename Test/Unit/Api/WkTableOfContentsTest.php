<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use Staempfli\Pdf\Api\FakePdfEngine;
use Staempfli\Pdf\Api\WkOptions;
use Staempfli\Pdf\Api\PdfTableOfContents;

class WkTableOfContentsTest extends \PHPUnit_Framework_TestCase
{
    /** @var FakePdfEngine */
    private $pdfEngine;
    /** @var PdfTableOfContents */
    private $tableOfContents;

    protected function setUp()
    {
        $this->pdfEngine = new FakePdfEngine();
        $this->tableOfContents = new PdfTableOfContents($this->pdfEngine);
    }
    public function testPrintToc()
    {
        $this->tableOfContents->printToc(new WkOptions(['print-option' => 'something']));
        $this->assertEquals(new WkOptions(['print-option' => 'something']), $this->pdfEngine->tableOfContents);
    }
}
