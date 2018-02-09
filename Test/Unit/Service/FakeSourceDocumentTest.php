<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Unit\Service;

use StaempfliPdf\Test\Service\FakePdfEngine;
use Staempfli\Pdf\Test\Service\FakeSourceDocument;
use Staempfli\Pdf\Service\PdfAppendContent;
use Staempfli\Pdf\Service\PdfOptions;

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
