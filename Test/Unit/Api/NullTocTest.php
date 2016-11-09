<?php
namespace Staempfli\Pdf\Test\Unit\Api;


use Staempfli\Pdf\Api\NullToc;
use Staempfli\Pdf\Api\WkOptions;


class NullTocTest extends \PHPUnit_Framework_TestCase
{
    public function testNullTocIdentity()
    {
        $nullToc = new NullToc();
        $this->assertSame($nullToc, $nullToc->withOptions(new WkOptions(['things-that-happen' => 'nothing'])));
    }
    public function testNullTocProperties()
    {
        $nullToc = new NullToc();
        $this->assertEquals([], \iterator_to_array($nullToc->options()));
    }
}
