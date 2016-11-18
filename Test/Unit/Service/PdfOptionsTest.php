<?php
namespace Staempfli\Pdf\Test\Unit\Service;

use Staempfli\Pdf\Service\PdfOptions;

class PdfOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $array = [
            'some-key' => 'some-value',
            'other-key' => 'other-value',
        ];
        $options = new PdfOptions($array);
        $this->assertEquals($array, $options->asArray());
    }
    /**
     * @dataProvider dataMerge
     * @param $originalValues
     * @param $valuesToMerge
     * @param $expectedMergedValues
     */
    public function testMerge($originalValues, $valuesToMerge, $expectedMergedValues)
    {
        $options = new PdfOptions($originalValues);
        $mergedOptions = $options->merge(new PdfOptions($valuesToMerge));
        $this->assertEquals(
            $expectedMergedValues,
            \iterator_to_array($mergedOptions)
        );
        $this->assertEquals(
            $originalValues,
            \iterator_to_array($options),
            'original options should be unchanged'
        );
    }
    public static function dataMerge()
    {
        return [
            [
                'original' => ['some-key' => 'some-default-value', 'other-key' => 'other-default-value'],
                'to_merge' => ['some-key' => 'overridden-value', 'new-key' => 'new-value'],
                'expected' => ['some-key' => 'overridden-value', 'other-key' => 'other-default-value', 'new-key' => 'new-value'],
            ],
        ];
    }
}
