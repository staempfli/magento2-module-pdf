<?php
namespace Staempfli\Pdf\Adapter;


use mikehaertl\wkhtmlto\Pdf;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Api\PdfFile;

/**
 * This is the adapter to the actual PDF generating library.
 */
final class WkPdfEngine implements PdfEngine
{
    /** @var Pdf */
    private $wkPdf;

    public function __construct(Pdf $wkPdf)
    {
        $this->wkPdf = $wkPdf;
    }

    public function __clone()
    {
        $this->wkPdf = clone $this->wkPdf;
    }

    public function addPage($html, Options $options)
    {
        $this->wkPdf->addPage($this->html($html), $options->asArray());
    }

    public function addCover($html, Options $options)
    {
        $this->wkPdf->addCover($this->html($html), $options->asArray());
    }

    public function addTableOfContents(Options $options)
    {
        $this->wkPdf->addToc($options->asArray());
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

    /**
     * Make sure, string is recognized as HTML, not file or URL
     *
     * @param $html
     * @return string
     */
    private function html($html)
    {
        if (!preg_match(Pdf::REGEX_HTML, $html) && !preg_match(Pdf::REGEX_XML, $html)) {
            return sprintf('<html>%s</html>', $html);
        }
        return $html;
    }

}