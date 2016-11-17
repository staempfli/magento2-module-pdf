<?php
namespace Staempfli\Pdf\Test\Unit\Model;


use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Service\Pdf;
use Staempfli\Pdf\Service\PdfOptions;
use Staempfli\Pdf\Block\PdfTemplate;
use Staempfli\Pdf\Model\PdfFactory;


class PdfFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $pdfFactory = new PdfFactory(new FakePdfEngine());
        $pdf = $pdfFactory->create();
        $this->assertInstanceOf(Pdf::class, $pdf);

        $this->markTestIncomplete();

        // basic usage:

        /** @var $block PdfTemplate */
        $pdf->setOptions(new PdfOptions([]));
        $pdf->appendContent($block);
        $pdf->file()->toString();
    }
}
