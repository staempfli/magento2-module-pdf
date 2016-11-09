<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use Staempfli\Pdf\Api\WkOptions;
use Staempfli\Pdf\Api\WkPdfTableOfContents;

class WkTableOfContentsTest extends \PHPUnit_Framework_TestCase
{
    /** @var WkPdfTableOfContents */
    private $tableOfContents;

    protected function setUp()
    {
        $this->tableOfContents = new WkPdfTableOfContents();
        $this->assertEquals(new WkOptions(), $this->tableOfContents->options());
    }
    public function testWithOptions()
    {
        $tocWithOptions = $this->tableOfContents->withOptions(new WkOptions(['option1' => 'value1']));
        $this->assertEquals(new WkOptions(['option1' => 'value1']), $tocWithOptions->options());
        $this->assertEquals(new WkOptions(), $this->tableOfContents->options(), 'original instance should be unchanged');
    }
    public function testWithOptionsMerged()
    {
        $tocWithOptions = $this->tableOfContents
            ->withOptions(new WkOptions(['option1' => 'value1']))
            ->withOptions(new WkOptions(['option2' => 'value2']))
            ->withOptions(new WkOptions(['option1' => 'overridden']));
        $this->assertEquals(new WkOptions(['option1' => 'overridden', 'option2' => 'value2']), $tocWithOptions->options());
        $this->assertEquals(new WkOptions(), $this->tableOfContents->options(), 'original instance should be unchanged');
    }
}
