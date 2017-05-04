<?php
namespace Staempfli\Pdf\Service;

use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Service\PdfAppendContent;
use Staempfli\Pdf\Service\PdfCover;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Api\PdfFile;
use Staempfli\Pdf\Service\PdfOptions;
use Staempfli\Pdf\Service\PdfTableOfContents;
use Staempfli\Pdf\Api\SourceDocument;

/**
 * PDF service. Entry point for clients.
 */
class Pdf
{
    /** @var PdfEngine */
    private $engine;
    /** @var Options */
    private $options;

    public function __construct(PdfEngine $engine)
    {
        $this->engine = $engine;
        $this->options = new PdfOptions();
    }

    /**
     * Replace options
     *
     * @param Options $options
     */
    public function setOptions(Options $options)
    {
        $this->options = $options;
    }

    /**
     * Add/override options
     *
     * @param Options $options
     */
    public function addOptions(Options $options)
    {
        $this->options = $this->options->merge($options);
    }

    /**
     * All options that can be specified for a page object can also be specified for
     * a toc, further more the options from the TOC Options section can also be
     * applied. The table of content is generated via XSLT which means that it can be
     * styled to look however you want it to look. To get an aide of how to do this
     * you can dump the default xslt document by supplying the
     * --dump-default-toc-xsl, and the outline it works on by supplying
     * --dump-outline, see the Outline Options section.
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param Options $tocOptions
     */
    public function appendTableOfContents(Options $tocOptions)
    {
        $toc = new PdfTableOfContents($this->engine);
        $toc->printToc($tocOptions);
    }

    /**
     * A page object puts the content of a singe webpage into the output document.
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param SourceDocument $source
     */
    public function appendContent(SourceDocument $source)
    {
        $source->printTo(new PdfAppendContent($this->engine));
    }

    /**
     * A cover object puts the content of a singe webpage into the output document,
     * the page does not appear in the table of content, and does not have headers
     * and footers.
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param SourceDocument $source
     */
    public function appendCover(SourceDocument $source)
    {
        $source->printTo(new PdfCover($this->engine));
    }
    /**
     * @return PdfFile
     */
    public function file()
    {
        return $this->engine->generatePdf($this->options);
    }
}