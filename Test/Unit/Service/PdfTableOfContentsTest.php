<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Unit\Service;

use Staempfli\Pdf\Test\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfOptions;
use Staempfli\Pdf\Service\PdfTableOfContents;

class PdfTableOfContentsTest extends \PHPUnit_Framework_TestCase
{
    /** @var FakePdfEngine */
    private $pdfEngine;
    /** @var PdfTableOfContents */
    private $tableOfContents;

    public function testPrintToc()
    {
        $this->tableOfContents->printToc(new PdfOptions(['print-option' => 'something']));
        $this->assertEquals(new PdfOptions(['print-option' => 'something']), $this->pdfEngine->tableOfContents);
    }

    protected function setUp()
    {
        $this->pdfEngine = new \Staempfli\Pdf\Test\Service\FakePdfEngine();
        $this->tableOfContents = new PdfTableOfContents($this->pdfEngine);
    }
}
