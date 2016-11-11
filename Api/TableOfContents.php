<?php
namespace Staempfli\Pdf\Api;


interface TableOfContents
{
    public function printToc(Options $options);
}