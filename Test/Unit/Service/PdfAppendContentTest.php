<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Unit\Service;

use Staempfli\Pdf\Test\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfAppendContent;
use Staempfli\Pdf\Service\PdfOptions;

class PdfAppendContentTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FakePdfEngine */
    private $pdfEngine;
    /** @var PdfAppendContent */
    private $medium;

    public function testPrintHtml()
    {
        $html = '<h1>html</h1>';
        $options = new PdfOptions(['version' => 'html10']);
        $this->medium->printHtml($html, $options);
        $this->assertEquals(
            [[$html, $options]], $this->pdfEngine->pages);

        $additionalHtml = '<h1>more html</h1>';
        $additionalOptions = new PdfOptions(['version' => 'html11']);
        $this->medium->printHtml($additionalHtml, $additionalOptions);
        $this->assertEquals(
            [[$html, $options], [$additionalHtml, $additionalOptions]], $this->pdfEngine->pages);
    }

    protected function setUp()
    {
        $this->pdfEngine = new FakePdfEngine();
        $this->medium = new PdfAppendContent($this->pdfEngine);
    }
}