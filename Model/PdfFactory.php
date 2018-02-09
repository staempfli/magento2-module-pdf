<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Service\Pdf;
use Staempfli\Pdf\Service\PdfOptions;

/**
 * Factory for PDF service, with options from Magento configuration
 */
class PdfFactory
{
    /**
     * @var \Staempfli\Pdf\Api\PdfEngine
     */
    protected $pdfEngine;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param \Staempfli\Pdf\Api\PdfEngine $pdfEngine
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        PdfEngine $pdfEngine,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->pdfEngine = $pdfEngine;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return \Staempfli\Pdf\Service\Pdf
     */
    public function create()
    {
        $pdf = new Pdf($this->pdfEngine);
        $pdf->setOptions($this->optionsFromConfig());

        return $pdf;
    }

    /**
     * @return \Staempfli\Pdf\Service\PdfOptions
     */
    private function optionsFromConfig()
    {
        $config = function ($xpath) {
            return $this->scopeConfig->getValue($xpath);
        };
        $withoutNull = function (array $array) {
            return array_filter($array, function ($value) {
                return !is_null($value); //@codingStandardsIgnoreLine;
            });
        };

        return new PdfOptions(
            $withoutNull(
                [
                    PdfOptions::KEY_GLOBAL_BINARY => $config(Config::XML_PATH_BINARY),
                    PdfOptions::KEY_GLOBAL_VERSION9 => $config(Config::XML_PATH_VERSION9),
                    PdfOptions::KEY_GLOBAL_TMP_DIR => $config(Config::XML_PATH_TMP_DIR),
                    PdfOptions::KEY_GLOBAL_CLI_OPTIONS => $withoutNull([
                        PdfOptions::KEY_CLI_OPTIONS_ESCAPE_ARGS => $config(Config::XML_PATH_ESCAPE_ARGS),
                        PdfOptions::KEY_CLI_OPTIONS_USE_EXEC => $config(Config::XML_PATH_USE_EXEC),
                        PdfOptions::KEY_CLI_OPTIONS_XVFB_RUN_OPTIONS => $config(Config::XML_PATH_XVFB_RUN_OPTIONS),
                        PdfOptions::KEY_CLI_OPTIONS_XVFB_RUN_BINARY => $config(Config::XML_PATH_XVFB_RUN_BINARY),
                        PdfOptions::KEY_CLI_OPTIONS_USE_XVFB_RUN => $config(Config::XML_PATH_USE_XVFB_RUN),
                    ]),
                ]
            )
        );
    }
}
