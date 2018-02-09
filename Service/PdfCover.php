<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Service;

use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;

/**
 * Medium that appends HTML page as cover page to PDF
 */
final class PdfCover implements Medium
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
    public function printHtml($html, Options $options)
    {
        $this->pdfEngine->addCover($html, $options);
    }
}
