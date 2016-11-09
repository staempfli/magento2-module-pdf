<?php
namespace Staempfli\Pdf\Api;


interface TableOfContents
{
    /**
     * Returns new instance with overridden options
     *
     * @param Options $options
     * @return TableOfContents
     */
    public function withOptions(Options $options);

    /**
     * @return Options
     */
    public function options();
}