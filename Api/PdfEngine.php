<?php
namespace Staempfli\Pdf\Api;

interface PdfEngine
{
    /**
     * @param Options $globalOptions
     * @param Medium $cover
     * @param TableOfContents $toc
     * @param Medium[] ...$pages
     * @return GeneratedPdf
     */
    public function generatePdf(Options $globalOptions, Medium $cover, TableOfContents $toc, Medium ...$pages);
}