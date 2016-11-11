<?php
namespace Staempfli\Pdf\Api;

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