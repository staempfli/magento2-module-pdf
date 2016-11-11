<?php
namespace Staempfli\Pdf\Model;

use Staempfli\Pdf\Api\PdfFile;

/**
 * Interface for PDF files loaded from file cache
 */
class CachedPdfFile implements PdfFile
{
    public function __construct($pathToCachedFile)
    {
    }

    public function saveAs($path)
    {
        // TODO: Implement saveAs() method.
    }

    public function send()
    {
        // TODO: Implement send() method.
    }

    public function toString()
    {
        // TODO: Implement toString() method.
    }
}