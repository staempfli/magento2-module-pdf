<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use Staempfli\Pdf\Api\FakePdfEngine;
use Staempfli\Pdf\Api\WkOptions;
use Staempfli\Pdf\Api\PdfAppendContent;
use Staempfli\Pdf\Api\WkSourceDocument;

class WkSourceDocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testPrintToMedium()
    {
        $pdfEngine = new FakePdfEngine();

        $html = '<html><body>Hello World</body></html>';
        $options = new WkOptions(['html7' => true]);
        $doc = new WkSourceDocument($html, $options);
        $doc->printTo(new PdfAppendContent($pdfEngine));
        $this->assertEquals([$html, $options], $pdfEngine->pages[0]);
    }
}
