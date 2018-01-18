<?php
namespace Staempfli\Pdf\Test\Integration;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\TestFramework\ObjectManager;
use Staempfli\Pdf\Adapter\WkPdfException;
use Staempfli\Pdf\Model\Config;
use Staempfli\Pdf\Model\PdfFactory;
use Staempfli\Pdf\Service\FakeSourceDocument;
use Staempfli\Pdf\Service\PdfOptions;

class WkPdfEngineTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ObjectManager */
    protected $objectManager;
    /** @var PdfFactory */
    private $pdfFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
        $this->pdfFactory = $this->objectManager->create(PdfFactory::class);

        $wkhtmltopdfBinary = $this->getWkhtmltopdfBinary();
        if (! $this->isExecutable($wkhtmltopdfBinary)) {
            $this->markTestSkipped(
                sprintf(
                    'wkhtmltopdf binary not found at %s. If it is installed in a different location, '.
                    'please adjust the configuration.',
                    $wkhtmltopdfBinary
                )
            );
        }
    }
    public function testGeneratePdf()
    {
        $pdf = $this->pdfFactory->create();
        $pdf->appendCover(new FakeSourceDocument('<body>BIG COVER</body>', new PdfOptions([])));
        $pdf->appendTableOfContents(new PdfOptions([]));
        $pdf->appendContent(new FakeSourceDocument('<body>print me!</body>', new PdfOptions([])));
        $this->assertStringStartsWith('%PDF-', $pdf->file()->toString(), 'binary string should contain the PDF header');
    }

    public function testExceptionOnToString()
    {
        $this->setExpectedException(WkPdfException::class);
        $this->createInvalidPdf()->file()->toString();
    }

    public function testExceptionOnSend()
    {
        $this->setExpectedException(WkPdfException::class);
        $this->createInvalidPdf()->file()->send();
    }

    public function testExceptionOnSave()
    {
        $this->setExpectedException(WkPdfException::class);
        $this->createInvalidPdf()->file()->saveAs(\tempnam(\sys_get_temp_dir(), 'pdftest'));
    }

    /**
     * This test saves the generated file in tmp/staempfli_pdf.pdf for manual inspection
     */
    public function testSaveGeneratedPdfFile()
    {
        /*
         * Direct HTML in header does not work, and with file I get
         *
         *  > Error: Failed loading page file:///tmp/php_tmpfile_wjJkuX
         *
         * Restrict test to text headers
         */
        //$headerHtmlFile = new File('<html><body><strong>I am a HTML header</strong></body></html>');
        $pdf = $this->pdfFactory->create();
        $pdf->addOptions(new PdfOptions(
            [
                PdfOptions::KEY_GLOBAL_TITLE => 'TEST PDF',
                PdfOptions::KEY_PAGE_HEADER_SPACING => '10',
                PdfOptions::FLAG_PAGE_HEADER_LINE,
                PdfOptions::KEY_PAGE_HEADER_TEXT_LEFT => 'HEADER',
                PdfOptions::KEY_PAGE_HEADER_TEXT_RIGHT => 'Page [page]',
                PdfOptions::KEY_GLOBAL_IGNORE_WARNINGS => true,
                PdfOptions::KEY_PAGE_FOOTER_TEXT_LEFT => 'Hello, I am a footer.',
                PdfOptions::KEY_PAGE_FOOTER_TEXT_RIGHT => 'I am text based.'
            ]
        ));
        $pdf->appendCover(new FakeSourceDocument('<body>BIG COVER</body>', new PdfOptions([])));
        $pdf->appendTableOfContents(new PdfOptions([
        ]));
        $contentHtml = <<<'HTML'
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>
<body><h1>Überschrift</h1>eins<h1>Überschrift</h1>zwei<h2>Unterüberschrift</h2>drei</body></html>
HTML;
        $pdf->appendContent(new FakeSourceDocument($contentHtml, new PdfOptions([])));
        $pdf->file()->saveAs('tmp/staempflitest.pdf');
        $this->assertNotEmpty(\realpath('tmp/staempflitest.pdf'), 'File tmp/staempflitest.pdf should be saved');
        $this->assertGreaterThan(10000, \filesize(\realpath('tmp/staempflitest.pdf')), 'File tmp/staempflitest.pdf should be > 10 KB');
    }

    /**
     * @param $command
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedLocalVariable) // https://phpmd.org/rules/index.html
     */
    private function isExecutable($command)
    {
        exec($command . ' 1> /dev/null 2> /dev/null', $output, $return);
        return $return <= 1;
    }

    /**
     * @return mixed|string
     */
    private function getWkhtmltopdfBinary()
    {
        /** @var ScopeConfigInterface $config */
        $config = $this->objectManager->get(ScopeConfigInterface::class);
        $wkhtmltopdfBinary = $config->getValue(Config::XML_PATH_BINARY);
        if (empty($wkhtmltopdfBinary)) {
            return 'wkhtmltopdf';
        }
        return $wkhtmltopdfBinary;
    }

    /**
     * @return \Staempfli\Pdf\Service\Pdf
     */
    private function createInvalidPdf()
    {
        $pdf = $this->pdfFactory->create();
        $pdf->setOptions(
            new PdfOptions(
                [
                    'gibberish' => 'pffflllltt',
                ]
            )
        );
        return $pdf;
    }
}