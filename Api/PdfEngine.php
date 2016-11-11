<?php
namespace Staempfli\Pdf\Api;

interface PdfEngine
{
    /**
     * Append HTML content (Add "web page")
     *
     * @param $html
     * @param Options $options
     * @return mixed
     */
    public function addPage($html, Options $options);

    /**
     * Set HTML content as cover page
     *
     * @param $html
     * @param Options $options
     * @return mixed
     */
    public function setCover($html, Options $options);

    /**
     * Add table of contents with given options
     *
     * @param Options $options
     * @return mixed
     */
    public function setTableOfContents(Options $options);

    /**
     * @param Options $globalOptions
     * @return GeneratedPdf
     */
    public function generatePdf(Options $globalOptions);
}