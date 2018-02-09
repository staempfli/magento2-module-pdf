<?php

namespace Staempfli\Pdf\Api;

/**
 * A print medium. Receives HTML from SourceDocument.
 * @api
 */
interface Medium
{
    /**
     * Takes HTML and prints it
     *
     * @param string $html
     * @param Options $options
     * @return void
     */
    public function printHtml($html, Options $options);
}
