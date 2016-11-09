<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use Staempfli\Pdf\Api\WkOptions;
use Staempfli\Pdf\Api\WkPdfPage;
use Staempfli\Pdf\Api\WkSourceDocument;

class WkSourceDocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testPrintToMedium()
    {
        $html = '<html><body>Hello World</body></html>';
        $options = new WkOptions(['html7' => true]);
        $doc = new WkSourceDocument($html, $options);
        $page = $doc->printTo(new WkPdfPage());
        $this->assertInstanceOf(WkPdfPage::class, $page);
        $this->assertEquals($html, $page->html());
        $this->assertEquals($options, $page->options());
    }
}
