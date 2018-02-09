<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
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
     * @var \Staempfli\Pdf\Api\PdfEngine
     */
    private $pdfEngine;

    /**
     * @param \Staempfli\Pdf\Api\PdfEngine $pdfEngine
     */
    public function __construct(
        PdfEngine $pdfEngine
    ) {
        $this->pdfEngine = $pdfEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function printToc(Options $options)
    {
        $this->pdfEngine->addTableOfContents($options);
    }
}
