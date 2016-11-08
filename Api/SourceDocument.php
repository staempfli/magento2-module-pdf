<?php
namespace Staempfli\Pdf\Api;

interface SourceDocument
{
    public function printTo(Medium $medium);
}