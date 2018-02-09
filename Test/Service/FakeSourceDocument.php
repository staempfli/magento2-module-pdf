<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Service;

use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\SourceDocument;

/**
 * Minimal implementation of SourceDocument. Clients should provide their own implementation
 */
final class FakeSourceDocument implements SourceDocument
{
    /**
     * @var string
     */
    private $html;

    /**
     * @var \Staempfli\Pdf\Api\Options
     */
    private $options;

    /**
     * @param string $html
     * @param \Staempfli\Pdf\Api\Options $options
     */
    public function __construct($html, Options $options)
    {
        $this->html = $html;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function printTo(Medium $medium)
    {
        $medium->printHtml($this->html, $this->options);
    }
}
