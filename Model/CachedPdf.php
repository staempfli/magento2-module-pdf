<?php
namespace Staempfli\Pdf\Model;

use Staempfli\Pdf\Api\GeneratedPdf;

/**
 * Interface for PDF files loaded from file cache
 */
class CachedPdf implements GeneratedPdf
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