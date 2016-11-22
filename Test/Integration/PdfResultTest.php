<?php
namespace Staempfli\Pdf\Test\Integration;

use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\TestFramework\ObjectManager;
use Staempfli\Pdf\Model\View\PdfResult;

class PdfResultTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ObjectManager */
    protected $objectManager;
    /** @var  PdfResult */
    private $pdfResult;

    protected function setUp()
    {
        $this->objectManager = ObjectManager::getInstance();
        $this->pdfResult = $this->objectManager->create(PdfResult::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoAppArea frontend
     */
    public function testRenderPdfResponse()
    {
        /** @var HttpResponse $response */
        $response = $this->objectManager->create(HttpResponse::class);
        $this->pdfResult->addDefaultHandle();
        $this->pdfResult->renderResult($response);
        $this->assertNotFalse($response->getHeader('Content-type'), 'Content-type header should be present');
        $this->assertEquals('application/pdf', $response->getHeader('Content-type')->getFieldValue());
        $this->assertStringStartsWith('%PDF-', $response->getBody(), 'body should contain the PDF header');
    }
}