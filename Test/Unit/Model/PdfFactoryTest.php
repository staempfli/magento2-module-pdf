<?php
namespace Staempfli\Pdf\Test\Unit\Model;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Staempfli\Pdf\Model\Config;
use Staempfli\Pdf\Model\PdfFactory;
use Staempfli\Pdf\Service\FakePdfEngine;
use Staempfli\Pdf\Service\Pdf;
use Staempfli\Pdf\Service\PdfOptions;


class PdfFactoryTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @dataProvider dataScopeConfig
     * @param array $scopeConfigValueMap
     * @param array $expectedOptions
     */
    public function testOptionsFromConfig(array $scopeConfigValueMap, array $expectedOptions)
    {
        $this->stubConfig->method('getValue')->willReturnMap($scopeConfigValueMap);
        $pdfFactory = new PdfFactory($this->fakePdfEngine, $this->stubConfig);

        $pdfFactory->create()->file();

        $this->assertEquals(
            $expectedOptions,
            (array) $this->fakePdfEngine->globalOptions
        );
    }
    public static function dataScopeConfig()
    {
        $default = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        return [
            'default' => [
                'scope_config_value_map' => [
                    [Config::XML_PATH_BINARY, $default, null, null],
                    [Config::XML_PATH_VERSION9, $default, null, null],
                    [Config::XML_PATH_TMP_DIR, $default, null, null],
                    [Config::XML_PATH_ESCAPE_ARGS, $default, null, null],
                    [Config::XML_PATH_USE_EXEC, $default, null, null],
                    [Config::XML_PATH_USE_XVFB_RUN, $default, null, null],
                    [Config::XML_PATH_XVFB_RUN_BINARY, $default, null, null],
                    [Config::XML_PATH_XVFB_RUN_OPTIONS, $default, null, null],
                ],
                'expected_options' => [
                    PdfOptions::KEY_GLOBAL_CLI_OPTIONS => [
                    ]
                ]
            ],
            'all' => [
                'scope_config_value_map' => [
                    [Config::XML_PATH_BINARY, $default, null, '/usr/bin/wkpdf2html'],
                    [Config::XML_PATH_VERSION9, $default, null, true],
                    [Config::XML_PATH_TMP_DIR, $default, null, '/tmp/wkpdf'],
                    [Config::XML_PATH_ESCAPE_ARGS, $default, null, true],
                    [Config::XML_PATH_USE_EXEC, $default, null, true],
                    [Config::XML_PATH_USE_XVFB_RUN, $default, null, true],
                    [Config::XML_PATH_XVFB_RUN_BINARY, $default, null, 'xvfb-run'],
                    [Config::XML_PATH_XVFB_RUN_OPTIONS, $default, null, '--server-args="-screen 0, 1024x768x24"'],
                ],
                'expected_options' => [
                    PdfOptions::KEY_GLOBAL_BINARY => '/usr/bin/wkpdf2html',
                    PdfOptions::KEY_GLOBAL_VERSION9 => true,
                    PdfOptions::KEY_GLOBAL_TMP_DIR => '/tmp/wkpdf',
                    PdfOptions::KEY_GLOBAL_CLI_OPTIONS => [
                        PdfOptions::KEY_CLI_OPTIONS_ESCAPE_ARGS => true,
                        PdfOptions::KEY_CLI_OPTIONS_USE_EXEC => true,
                        PdfOptions::KEY_CLI_OPTIONS_USE_XVFB_RUN => true,
                        PdfOptions::KEY_CLI_OPTIONS_XVFB_RUN_BINARY => 'xvfb-run',
                        PdfOptions::KEY_CLI_OPTIONS_XVFB_RUN_OPTIONS => '--server-args="-screen 0, 1024x768x24"',
                    ]
                ]
            ]
        ];
    }
}
