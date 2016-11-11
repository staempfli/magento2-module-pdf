<?php
namespace Staempfli\Pdf\Api;


interface Medium
{
    /**
     * Takes HTML and prints it
     *
     * @param Options $options
     * @return Medium
     */
    public function printHtml($html, Options $options);

}