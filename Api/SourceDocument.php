<?php
namespace Staempfli\Pdf\Api;

interface SourceDocument
{
    /**
     * @param Medium $medium
     * @return void
     */
    public function printTo(Medium $medium);
}