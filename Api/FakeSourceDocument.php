<?php
namespace Staempfli\Pdf\Api;

/**
 * Minimal implementation of SourceDocument. Clients should provide their own implementation
 */
final class FakeSourceDocument implements SourceDocument
{
    /** @var string */
    private $html;
    /** @var array */
    private $options;

    /**
     * @param string $html
     * @param PdfOptions $options
     */
    public function __construct($html, PdfOptions $options)
    {
        $this->html = $html;
        $this->options = $options;
    }

    /**
     * @param Medium $medium
     * @return void
     */
    public function printTo(Medium $medium)
    {
        $medium->printHtml($this->html, $this->options);
    }

}