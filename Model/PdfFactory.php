<?php
namespace Staempfli\Pdf\Model;

use Magento\Framework\Filesystem\Io\File as FileSystem;
use Magento\Framework\ObjectManager\FactoryInterface;
use Staempfli\Pdf\Service\Pdf;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Service\PdfOptions;

class PdfFactory
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
        $builder = new Pdf($this->pdfEngine);
        $builder->setOptions($this->optionsFromConfig());
        return $builder;
    }

    private function optionsFromConfig()
    {
        //TODO retrieve global options from system configuration
        return new PdfOptions();
    }
}
