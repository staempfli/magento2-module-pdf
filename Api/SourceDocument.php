<?php
namespace Staempfli\Pdf\Api;

interface SourceDocument
{
    /**
     * @param Medium $medium
     * @return Medium
     */
    public function printTo(Medium $medium);
}