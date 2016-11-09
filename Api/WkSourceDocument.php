<?php
namespace Staempfli\Pdf\Api;

/**
 * Minimal implementation of SourceDocument. Clients should provide their own implementation
 */
final class WkSourceDocument implements SourceDocument
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
     * @param Medium $medium
     * @return Medium
     */
    public function printTo(Medium $medium)
    {
        return $medium->withHtml($this->html)->withOptions($this->options);
    }

}