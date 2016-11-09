<?php
namespace Staempfli\Pdf\Test\Unit\Api;


use Staempfli\Pdf\Api\NullMedium;
use Staempfli\Pdf\Api\WkOptions;


class NullMediumTest extends \PHPUnit_Framework_TestCase
{
    public function testNullMediumIdentity()
    {
        $nullMedium = new NullMedium();
        $this->assertSame($nullMedium, $nullMedium->withHtml('black hole'));
        $this->assertSame($nullMedium, $nullMedium->withOptions(new WkOptions(['things-that-happen' => 'nothing'])));
    }
    public function testNullMediumProperties()
    {
        $nullMedium = new NullMedium();
        $this->assertEquals([], \iterator_to_array($nullMedium->options()));
        $this->assertEquals('', $nullMedium->html());
    }
}
