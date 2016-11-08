<?php
namespace Staempfli\Pdf\Api;


class WkSourceDocument implements SourceDocument
{
    /** @var string */
    private $html;
    /** @var array */
    private $options;

    /**
     * @param string $html
     * @param WkOptions $options
     */
    public function __construct($html, WkOptions $options)
    {
        $this->html = $html;
        $this->options = $options;
    }


    /**
     * Named constructor: creates empty DIN A4 page
     */
    public static function dinA4()
    {
        return new static('', new WkOptions([WkOptions::KEY_PAGE_SIZE => WkOptions::PAGE_SIZE_DIN_A4]));
    }

    public function printTo(Medium $medium)
    {
        // TODO: Implement printTo() method.
    }

}