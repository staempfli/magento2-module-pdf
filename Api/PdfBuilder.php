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
    public function addPage(Medium $page)
    {
        $this->pages[] = $page;
    }
    public function setCover(Medium $cover)
    {
        $this->cover = $cover;
    }
    public function setTableOfContents(TableOfContents $tableOfContents)
    {
        $this->tableOfContents = $tableOfContents;
    }

    /**
     * @return GeneratedPdf
     */
    public function build()
    {
        return $this->engine->generatePdf($this->options, $this->cover, $this->tableOfContents, ...$this->pages);
    }
}