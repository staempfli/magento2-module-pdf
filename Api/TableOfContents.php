<?php
namespace Staempfli\Pdf\Api;

/**
 * Printable table of contents
 */
interface TableOfContents
{
    /**
     * Prints table of contents with given options
     *
     * @return void
     */
    public function printToc(Options $options);
}