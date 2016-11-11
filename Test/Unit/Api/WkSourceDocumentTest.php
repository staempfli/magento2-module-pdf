<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use Staempfli\Pdf\Api\FakePdfEngine;
use Staempfli\Pdf\Api\PdfOptions;
use Staempfli\Pdf\Api\PdfAppendContent;
use Staempfli\Pdf\Api\FakeSourceDocument;

class WkSourceDocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testPrintToMedium()
    {
        $pdfEngine = new FakePdfEngine();

        $html = '<html><body>Hello World</body></html>';
        $options = new PdfOptions(['html7' => true]);
        $doc = new FakeSourceDocument($html, $options);
        $doc->printTo(new PdfAppendContent($pdfEngine));
        $this->assertEquals([$html, $options], $pdfEngine->pages[0]);
    }
}
