<?php
namespace Staempfli\Pdf\Test\Unit\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Response\Http;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\OptionsFactory;
use Staempfli\Pdf\Model\PdfFactory;
use Staempfli\Pdf\Model\PdfResponse;
use Staempfli\Pdf\Model\PdfResponseFactory;
use Staempfli\Pdf\Model\View\PageResultWithoutHttp;
use Staempfli\Pdf\Model\View\PdfResult;
use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Service\PdfOptions;


class PdfResultTest extends \PHPUnit_Framework_TestCase
{
    /** @var FakePdfEngine */
    private $fakePdfEngine;

    /** @var ScopeConfigInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $stubConfig;

    protected function setUp()
    {
        $this->fakePdfEngine = new FakePdfEngine();
        $this->stubConfig = $this->getMockBuilder(ScopeConfigInterface::class)->getMockForAbstractClass();
    }

    public function testRenderWithOptions()
    {
        $pageResultMock = $this->getMockBuilder(PageResultWithoutHttp::class)->disableOriginalConstructor()->getMock();
        $pageResultMock->expects($this->once())
            ->method('renderNonHttpResult')
            ->with($this->isInstanceOf(PdfResponse::class))
            ->willReturnSelf();
        $optionsFactoryMock = $this->getMockBuilder(OptionsFactory::class)->disableOriginalConstructor()->setMethods(['create'])->getMock();
        $optionsFactoryMock->method('create')->willReturnCallback(function() { return new PdfOptions(); });
        $pdfResult = new PdfResult(
            $this->mockPdfResponseFactory(),
            new PdfFactory($this->fakePdfEngine, $this->stubConfig),
            $optionsFactoryMock,
            $pageResultMock
        );

        $pdfResult->addGlobalOptions(new PdfOptions(
            [
                PdfOptions::KEY_GLOBAL_ORIENTATION => PdfOptions::ORIENTATION_LANDSCAPE,
            ]
        ));
        $pdfResult->addPageOptions(new PdfOptions(
            [
                PdfOptions::KEY_PAGE_COOKIES => ['frontend' => '0123456789abcdef0123456789abcdef'],
            ]
        ));
        $pdfResult->renderResult($this->getMockBuilder(Http::class)->disableOriginalConstructor()->getMock());

        $this->assertEquals(new PdfOptions(
            [
                PdfOptions::KEY_GLOBAL_CLI_OPTIONS => [],
                PdfOptions::KEY_GLOBAL_ORIENTATION => PdfOptions::ORIENTATION_LANDSCAPE,
            ]
        ), $this->fakePdfEngine->globalOptions);
        $this->assertEquals(new PdfOptions(
            [
                PdfOptions::KEY_PAGE_COOKIES => ['frontend' => '0123456789abcdef0123456789abcdef'],
            ]
        ), $this->fakePdfEngine->pages[0][1]);
    }

    /**
     * @return PdfResponseFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private function mockPdfResponseFactory()
    {
        $pdfResponseFactory = $this->getMockBuilder(PdfResponseFactory::class)->disableOriginalConstructor()->setMethods(['create'])->getMock();
        $pdfResponseFactory->method('create')->willReturnCallback(
            function($data) {
                return new PdfResponse($data[PdfResponse::PARAM_OPTIONS]);
            }
        );
        return $pdfResponseFactory;
    }
}
