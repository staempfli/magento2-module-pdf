<?php
namespace Staempfli\Pdf\Service;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\SourceDocument;

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
     * @param Options $options
     */
    public function __construct($html, Options $options)
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