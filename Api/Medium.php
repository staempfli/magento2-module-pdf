<?php
namespace Staempfli\Pdf\Api;


interface Medium
{
    /**
     * Returns new instance with HTML source
     *
     * @param string $source
     * @return Medium
     */
    public function withHtml($source);

    /**
     * Returns new instance with overridden options
     *
     * @param Options $options
     * @return Medium
     */
    public function withOptions(Options $options);

    /**
     * @return string
     */
    public function html();

    /**
     * @return Options
     */
    public function options();
}