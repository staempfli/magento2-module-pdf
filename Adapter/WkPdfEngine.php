<?php
namespace Staempfli\Pdf\Adapter;


use mikehaertl\wkhtmlto\Pdf;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Api\PdfFile;

final class WkPdfEngine implements PdfEngine
{
    /** @var Pdf */
    private $wkPdf;

    public function __construct(Pdf $wkPdf)
    {
        $this->wkPdf = $wkPdf;
    }

    public function addPage($html, Options $options)
    {
        /*
         * Make sure, it is recognized as HTML, not file or URL
         */
        if (! preg_match(Pdf::REGEX_HTML, $html) && ! preg_match(Pdf::REGEX_XML, $html)) {
            $html = sprintf('<html>%s</html>', $html);
        }
        $this->wkPdf->addPage($html, $options->asArray());
    }

    public function setCover($html, Options $options)
    {
        // TODO: Implement setCover() method.
    }

    public function setTableOfContents(Options $options)
    {
        // TODO: Implement setTableOfContents() method.
    }

    /**
     * @param Options $globalOptions
     * @return PdfFile
     */
    public function generatePdf(Options $globalOptions)
    {
        /*
         * No factory here, WkPdfEngine and WkPdfFile are tightly coupled and should only be exchanged together
         */
        $wkPdf = clone $this->wkPdf;
        $wkPdf->setOptions($globalOptions->asArray());
        return new WkPdfFile($wkPdf);
    }

}