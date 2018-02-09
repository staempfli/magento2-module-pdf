<?php

namespace Staempfli\Pdf\Api;

/**
 * Document that can print itself as HTML to a print medium
 * @api
 */
interface SourceDocument
{
    /**
     * @param Medium $medium
     * @return void
     */
    public function printTo(Medium $medium);
}
