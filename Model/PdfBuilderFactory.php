<?php
namespace Staempfli\Pdf\Model;

use Magento\Framework\Filesystem\Io\File as FileSystem;
use Magento\Framework\ObjectManager\FactoryInterface;
use Staempfli\Pdf\Api\PdfBuilder;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Api\WkOptions;

class PdfBuilderFactory
{
    /**
     * @var PdfEngine
     */
    protected $pdfEngine;

    public function __construct(PdfEngine $pdfEngine)
    {
        $this->pdfEngine = $pdfEngine;
    }

    public function create()
    {
        $builder = new PdfBuilder($this->pdfEngine);
        $builder->setOptions($this->optionsFromConfig());
        return $builder;
    }

    private function optionsFromConfig()
    {
        //TODO retrieve global options from system configuration
        return new WkOptions();
    }
}
