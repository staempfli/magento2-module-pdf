<?php
namespace Staempfli\Pdf\Api;

class PdfBuilder
{
    /** @var PdfEngine */
    private $engine;
    /** @var Options */
    private $options;
    /** @var Medium */
    private $cover;
    /** @var TableOfContents */
    private $tableOfContents;
    /** @var Medium[] */
    private $pages = [];

    public function __construct(PdfEngine $engine)
    {
        $this->engine = $engine;
        $this->options = new WkOptions();
        $this->cover = new NullMedium();
        $this->tableOfContents = new NullToc();
    }

    public function setOptions(Options $options)
    {
        $this->options = $options;
    }

    /**
     * A page objects puts the content of a singe webpage into the output document.
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param Medium $page
     */
    public function addPage(Medium $page)
    {
        $this->pages[] = $page;
    }

    /**
     * A cover objects puts the content of a singe webpage into the output document,
     * the page does not appear in the table of content, and does not have headers
     * and footers.
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param Medium $cover
     */
    public function setCover(Medium $cover)
    {
        $this->cover = $cover;
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
     * @param TableOfContents $tableOfContents
     */
    public function setTableOfContents(TableOfContents $tableOfContents)
    {
        $this->tableOfContents = $tableOfContents;
    }

    /**
     * A page objects puts the content of a singe webpage into the output document.
     *
     * @see http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     * @param SourceDocument $source
     */
    public function addPageFromSource(SourceDocument $source)
    {
        //TODO decide if Medium abstraction can be dropped
        // => $this->pages[] = $source;
        // alternatively rename WkPdfPage to WkPdfMedium and make addPage() private
        // to not confuse "web page" with "pdf page"
        $this->addPage($source->printTo(new WkPdfPage()));
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
    public function setCoverFromSource(SourceDocument $source)
    {
        //TODO decide if Medium abstraction can be dropped
        // => $this->cover = $source;
        $this->setCover($source->printTo(new WkPdfPage()));
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
        $this->options[WkOptions::KEY_HEADER_HTML] = $html;
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
        $this->options[WkOptions::KEY_FOOTER_HTML] = $html;
    }

    /**
     * @return GeneratedPdf
     */
    public function build()
    {
        return $this->engine->generatePdf($this->options, $this->cover, $this->tableOfContents, ...$this->pages);
    }
}