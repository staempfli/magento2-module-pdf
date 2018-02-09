<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Integration;

use Magento\Framework\View\Element\Text;
use Magento\Framework\View\Layout;
use Magento\TestFramework\ObjectManager;
use Staempfli\Pdf\Block\PdfTemplate;
use Staempfli\Pdf\Test\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfAppendContent;
use Staempfli\Pdf\Service\PdfOptions;

class PdfTemplateTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ObjectManager */
    protected $objectManager;
    /** @var Layout */
    private $layout;

    /**
     * @magentoAppIsolation enabled
     * @magentoAppArea frontend
     */
    public function testPrint()
    {
        $fakePdfEngine = new FakePdfEngine();
        /** @var PdfTemplate $pdfTemplate */
        $pdfTemplate = $this->layout->createBlock(PdfTemplate::class, 'pdftest-container');
        $pdfTemplate->addChild('pdftest-element', Text::class, ['text' => 'test']);
        $pdfTemplate->printTo(new PdfAppendContent($fakePdfEngine));

        $this->assertEquals(
            [['test', new PdfOptions([])]],
            $fakePdfEngine->pages
        );
    }

    protected function setUp()
    {
        $this->objectManager = ObjectManager::getInstance();
        $this->layout = $this->objectManager->get(Layout::class);
    }
}
