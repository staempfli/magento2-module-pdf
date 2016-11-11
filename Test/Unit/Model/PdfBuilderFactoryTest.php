<?php
namespace Staempfli\Pdf\Test\Unit\Model;


use Staempfli\Pdf\Api\FakePdfEngine;
use Staempfli\Pdf\Api\PdfBuilder;
use Staempfli\Pdf\Api\WkOptions;
use Staempfli\Pdf\Api\PdfAppendContent;
use Staempfli\Pdf\Block\PdfTemplate;
use Staempfli\Pdf\Model\PdfBuilderFactory;


class PdfBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $pdfBuilderFactory = new PdfBuilderFactory(new FakePdfEngine());
        $pdfBuilder = $pdfBuilderFactory->create();
        $this->assertInstanceOf(PdfBuilder::class, $pdfBuilder);

        $this->markTestIncomplete();

        // basic usage:

        /** @var $block PdfTemplate */
        $pdfBuilder->setOptions(new WkOptions([]));
        $pdfBuilder->appendContent($block);
        $pdfBuilder->build()->toString();
    }
}
