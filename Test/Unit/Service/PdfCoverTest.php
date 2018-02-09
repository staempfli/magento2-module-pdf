<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Unit\Service;

use Staempfli\Pdf\Test\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfCover;
use Staempfli\Pdf\Service\PdfOptions;

class PdfCoverTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FakePdfEngine */
    private $pdfEngine;
    /** @var PdfCover */
    private $medium;

    public function testPrintHtml()
    {
        $html = '<title>COVER</title>';
        $options = new PdfOptions(['size' => 'huge']);
        $this->medium->printHtml($html, $options);
        $this->assertEquals([$html, $options], $this->pdfEngine->cover);

        $html = '<title>NEW COVER</title>';
        $options = new PdfOptions(['new' => 'true']);
        $this->medium->printHtml($html, $options);
        $this->assertEquals([$html, $options], $this->pdfEngine->cover);
    }

    protected function setUp()
    {
        $this->pdfEngine = new FakePdfEngine();
        $this->medium = new PdfCover($this->pdfEngine);
    }
}