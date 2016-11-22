<?php
namespace Staempfli\Pdf\Test\Integration;

use Magento\Framework\View\Element\Text;
use Magento\Framework\View\Layout;
use Magento\TestFramework\ObjectManager;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Staempfli\Pdf\Block\PdfTemplate;
use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Service\Pdf;
use Staempfli\Pdf\Service\PdfAppendContent;
use Staempfli\Pdf\Service\PdfOptions;

class PdfTemplateTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ObjectManager */
    protected $objectManager;
    /** @var Layout */
    private $layout;

    protected function setUp()
    {
        $this->objectManager = ObjectManager::getInstance();
        $this->layout = $this->objectManager->get(Layout::class);
    }

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
}
