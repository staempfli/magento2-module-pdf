<?php
namespace Staempfli\Pdf\Service;

use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;
use Staempfli\Pdf\Api\TableOfContents;

/**
 * Table of contents that appends itself to PDF
 */
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
        $this->pdfEngine->addTableOfContents($options);
    }

}