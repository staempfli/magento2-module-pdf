<?php
namespace Staempfli\Pdf\Api;

final class PdfTableOfContents implements TableOfContents
{
    /**
     * @var PdfEngine
     */
    private $pdfEngine;

    public function __construct(PdfEngine $pdfEngine)
    {
        $this->pdfEngine = $pdfEngine;
    }

    public function printToc(Options $options)
    {
        $this->pdfEngine->setTableOfContents($options);
    }

}