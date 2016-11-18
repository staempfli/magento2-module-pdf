<?php
namespace Staempfli\Pdf\Test\Integration;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\TestFramework\ObjectManager;
use Staempfli\Pdf\Model\Config;
use Staempfli\Pdf\Model\PdfFactory;
use Staempfli\Pdf\Service\FakeSourceDocument;
use Staempfli\Pdf\Service\PdfOptions;

class WkPdfEngineTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ObjectManager */
    protected $objectManager;
    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
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
    public function testGeneratePdfFile()
    {
        /** @var PdfFactory $pdfFactory */
        $pdfFactory = $this->objectManager->create(PdfFactory::class);
        $pdf = $pdfFactory->create();
        $pdf->appendContent(new FakeSourceDocument('<body>print me!</body>', new PdfOptions([])));
        $this->assertStringStartsWith('%PDF-', $pdf->file()->toString(), 'binary string should contain the PDF header');
    }

    /**
     * @param $command
     * @return bool
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
}