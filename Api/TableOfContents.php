<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Api;

/**
 * Printable table of contents
 * @api
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
