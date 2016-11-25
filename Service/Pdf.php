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
     * A page objects puts the content of a singe webpage into the output document.
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param SourceDocument $source
     */
    public function appendContent(SourceDocument $source)
    {
        $source->printTo(new PdfAppendContent($this->engine));
    }

    /**
    /**
     * A cover objects puts the content of a singe webpage into the output document,
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
     * In header and footer text string supplied
     * to e.g. --header-left, the following variables will be substituted.
     *
     * [page]       Replaced by the number of the pages currently being printed
     * [frompage]   Replaced by the number of the first page to be printed
     * [topage]     Replaced by the number of the last page to be printed
     * [webpage]    Replaced by the URL of the page being printed
     * [section]    Replaced by the name of the current section
     * [subsection] Replaced by the name of the current subsection
     * [date]       Replaced by the current date in system local format
     * [isodate]    Replaced by the current date in ISO 8601 extended format
     * [time]       Replaced by the current time in system local format
     * [title]      Replaced by the title of the of the current page object
     * [doctitle]   Replaced by the title of the output document
     * [sitepage]   Replaced by the number of the page in the current site being converted
     * [sitepages]  Replaced by the number of pages in the current site being converted
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param $html
     */
    public function setHeaderHtml($html)
    {
        $this->options[PdfOptions::KEY_PAGE_HEADER_HTML_URL] = $html;
    }

    /**
     * In header and footer text string supplied
     * to e.g. --header-left, the following variables will be substituted.
     *
     * [page]       Replaced by the number of the pages currently being printed
     * [frompage]   Replaced by the number of the first page to be printed
     * [topage]     Replaced by the number of the last page to be printed
     * [webpage]    Replaced by the URL of the page being printed
     * [section]    Replaced by the name of the current section
     * [subsection] Replaced by the name of the current subsection
     * [date]       Replaced by the current date in system local format
     * [isodate]    Replaced by the current date in ISO 8601 extended format
     * [time]       Replaced by the current time in system local format
     * [title]      Replaced by the title of the of the current page object
     * [doctitle]   Replaced by the title of the output document
     * [sitepage]   Replaced by the number of the page in the current site being converted
     * [sitepages]  Replaced by the number of pages in the current site being converted
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param $html
     */
    public function setFooterHtml($html)
    {
        $this->options[PdfOptions::KEY_PAGE_FOOTER_HTML_URL] = $html;
    }

    /**
     * @return PdfFile
     */
    public function file()
    {
        return $this->engine->generatePdf($this->options);
    }
}