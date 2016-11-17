<?php
namespace Staempfli\Pdf\Test\Unit\Service;

use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfOptions;
use Staempfli\Pdf\Service\PdfAppendContent;

class PdfAppendContentTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FakePdfEngine */
    private $pdfEngine;
    /** @var PdfAppendContent */
    private $medium;

    protected function setUp()
    {
        $this->pdfEngine = new FakePdfEngine();
        $this->medium = new PdfAppendContent($this->pdfEngine);
    }
    public function testPrintHtml()
    {
        $html = '<h1>html</h1>';
        $options = new PdfOptions(['version' => 'html10']);
        $this->medium->printHtml($html, $options);
        $this->assertEquals(
            [[$html, $options]], $this->pdfEngine->pages);

        $html2 = '<h1>more html</h1>';
        $options2 = new PdfOptions(['version' => 'html11']);
        $this->medium->printHtml($html2, $options2);
        $this->assertEquals(
            [[$html, $options], [$html2, $options2]], $this->pdfEngine->pages);
    }
}