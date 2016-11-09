<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use Staempfli\Pdf\Api\WkOptions;
use Staempfli\Pdf\Api\WkPdfPage;

class WkPdfPageTest extends \PHPUnit_Framework_TestCase
{
    /** @var WkPdfPage */
    private $page;

    protected function setUp()
    {
        $this->page = new WkPdfPage();
        $this->assertSame('', $this->page->html());
        $this->assertEquals(new WkOptions(), $this->page->options());
    }
    public function testWithHtml()
    {
        $pageWithHtml = $this->page->withHtml('<h1>HTML!</h1>');
        $this->assertSame('<h1>HTML!</h1>', $pageWithHtml->html());
        $this->assertSame('', $this->page->html(), 'original instance should be unchanged');
    }
    public function testWithOptions()
    {
        $pageWithOptions = $this->page->withOptions(new WkOptions(['option1' => 'value1']));
        $this->assertEquals(new WkOptions(['option1' => 'value1']), $pageWithOptions->options());
        $this->assertEquals(new WkOptions(), $this->page->options(), 'original instance should be unchanged');
    }
    public function testWithOptionsMerged()
    {
        $pageWithOptions = $this->page
            ->withOptions(new WkOptions(['option1' => 'value1']))
            ->withOptions(new WkOptions(['option2' => 'value2']))
            ->withOptions(new WkOptions(['option1' => 'overridden']));
        $this->assertEquals(new WkOptions(['option1' => 'overridden', 'option2' => 'value2']), $pageWithOptions->options());
        $this->assertEquals(new WkOptions(), $this->page->options(), 'original instance should be unchanged');
    }
}
