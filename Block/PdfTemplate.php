<?php
namespace Staempfli\Pdf\Block;

use Magento\Framework\View\Element\Template;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\SourceDocument;

class PdfTemplate extends Template implements SourceDocument
{
    public function printTo(Medium $medium)
    {
        // TODO: Implement printTo() method.
    }

}