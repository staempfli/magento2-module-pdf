<?php
namespace Staempfli\Pdf\Test\Unit\Service;

use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfOptions;
use Staempfli\Pdf\Service\PdfAppendContent;
use Staempfli\Pdf\Service\FakeSourceDocument;

class FakeSourceDocumentTest extends \PHPUnit_Framework_TestCase
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
