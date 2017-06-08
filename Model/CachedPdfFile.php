<?php
namespace Staempfli\Pdf\Model;

use Staempfli\Pdf\Api\PdfFile;

/**
 * Interface for PDF files loaded from file cache
 */
class CachedPdfFile implements PdfFile
{
    /**
     * CachedPdfFile constructor.
     * @param $pathToCachedFile
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) // https://phpmd.org/rules/index.html
     */
    public function __construct($pathToCachedFile)
    {
    }

    /**
     * @param string $path
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) // https://phpmd.org/rules/index.html
     */
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