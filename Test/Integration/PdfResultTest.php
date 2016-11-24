<?php
namespace Staempfli\Pdf\Test\Integration;

use Magento\Backend\Model\View\Result\Page;
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
        $this->objectManager->get(Page::class)->addDefaultHandle();
        $this->pdfResult->setFilename('testpdf.pdf');
        $this->pdfResult->renderResult($response);

        $this->assertResponseHeader($response, 'Content-type', $this->equalTo('application/pdf'));
        $this->assertResponseHeader($response, 'Content-length', $this->greaterThan(1000), 'Content-length header should be at least 1K');
        $this->assertResponseHeader($response, 'Cache-Control', $this->equalTo('must-revalidate, post-check=0, pre-check=0'));
        $this->assertResponseHeader($response, 'Last-Modified', $this->callback(function($lastModified) {
            return \strtotime($lastModified) > \time() - 10;
        }), 'Last-Modified header should be about right now');
        $this->assertResponseHeader($response, 'Content-Disposition', $this->equalTo('attachment; filename="testpdf.pdf"'));
        $this->assertStringStartsWith('%PDF-', $response->getBody(), 'body should contain the PDF header');
    }

    /**
     * @param HttpResponse $response
     * @param string $field
     * @param \PHPUnit_Framework_Constraint $constraint
     */
    private function assertResponseHeader(HttpResponse $response, $field, \PHPUnit_Framework_Constraint $constraint, $message = '')
    {
        $this->assertNotFalse($response->getHeader($field), "{$field} header should be present");
        $this->assertThat($response->getHeader($field)->getFieldValue(), $constraint, $message);
    }
}