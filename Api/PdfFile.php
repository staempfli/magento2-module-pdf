<?php
namespace Staempfli\Pdf\Api;

/**
 * Result of underlying PDF engine. Implemented by adapter
 */
interface PdfFile
{
    /**
     * @param string $path
     * @return void
     */
    public function saveAs($path);

    /**
     * @return void
     */
    public function send();

    /**
     * @return string
     */
    public function toString();
}