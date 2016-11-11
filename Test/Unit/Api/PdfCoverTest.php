<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use Staempfli\Pdf\Api\FakePdfEngine;
use Staempfli\Pdf\Api\PdfCover;
use Staempfli\Pdf\Api\WkOptions;

class PdfCoverTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FakePdfEngine */
    private $pdfEngine;
    /** @var PdfCover */
    private $medium;

    protected function setUp()
    {
        $this->pdfEngine = new FakePdfEngine();
        $this->medium = new PdfCover($this->pdfEngine);
    }
    public function testPrintHtml()
    {
        $html = '<title>COVER</title>';
        $options = new WkOptions(['size' => 'huge']);
        $this->medium->printHtml($html, $options);
        $this->assertEquals([$html, $options], $this->pdfEngine->cover);

        $html = '<title>NEW COVER</title>';
        $options = new WkOptions(['new' => 'true']);
        $this->medium->printHtml($html, $options);
        $this->assertEquals([$html, $options], $this->pdfEngine->cover);
    }
}