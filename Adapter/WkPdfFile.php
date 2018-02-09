<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Adapter;

use mikehaertl\wkhtmlto\Pdf;
use Staempfli\Pdf\Api\PdfFile;

/**
 * This is the adapter to the actual PDF generating library.
 */
final class WkPdfFile implements PdfFile
{
    /**
     * @var \mikehaertl\wkhtmlto\Pdf
     */
    private $wkPdf;

    /**
     * @param \mikehaertl\wkhtmlto\Pdf $wkPdf
     */
    public function __construct(
        Pdf $wkPdf
    ) {
        $this->wkPdf = $wkPdf;
    }

    /**
     * {@inheritdoc}
     */
    public function saveAs($path)
    {
        if (false === $this->wkPdf->saveAs($path)) {
            throw new WkPdfException($this->wkPdf->getError());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        if (false === $this->wkPdf->send()) {
            throw new WkPdfException($this->wkPdf->getError());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        $result = $this->wkPdf->toString();
        if ($result === false) {
            throw new WkPdfException($this->wkPdf->getError());
        }

        return $result;
    }
}
