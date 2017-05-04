<?php
namespace Staempfli\Pdf\Api;

/**
 * Underlying PDF engine, implemented by adapter
 */
interface PdfEngine
{
    /**
     * Append HTML content (Add "web page")
     *
     * @param $html
     * @param Options $options
     * @return void
     */
    public function addPage($html, Options $options);

    /**
     * Append HTML content as cover page
     *
     * @param string $html
     * @param Options $options
     * @return void
     */
    public function addCover($html, Options $options);

    /**
     * Append table of contents with given options
     *
     * @param Options $options
     * @return void
     */
    public function addTableOfContents(Options $options);

    /**
     * @param Options $globalOptions
     * @return PdfFile
     */
    public function generatePdf(Options $globalOptions);
}