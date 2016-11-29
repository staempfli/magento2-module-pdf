<?php
namespace Staempfli\Pdf\Adapter;

use mikehaertl\wkhtmlto\Pdf;
use Staempfli\Pdf\Api\PdfFile;

/**
 * This is the adapter to the actual PDF generating library.
 */
final class WkPdfFile implements PdfFile
{
    /** @var Pdf */
    private $wkPdf;

    public function __construct(Pdf $wkPdf)
    {
        $this->wkPdf = $wkPdf;
    }

    public function saveAs($path)
    {
        if (false === $this->wkPdf->saveAs($path)) {
            throw new WkPdfException($this->wkPdf->getError());
        }
    }

    public function send()
    {
        if (false === $this->wkPdf->send()) {
            throw new WkPdfException($this->wkPdf->getError());
        }
    }

    public function toString()
    {
        $result = $this->wkPdf->toString();
        if ($result === false) {
            throw new WkPdfException($this->wkPdf->getError());
        }
        return $result;
    }

}