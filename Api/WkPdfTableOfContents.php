<?php
namespace Staempfli\Pdf\Api;


class WkPdfTableOfContents implements TableOfContents
{
    /** @var Options */
    private $options;

    public function __construct()
    {
        $this->options = new WkOptions();
    }

    public function withOptions(Options $wkTocOptions)
    {
        $toc = clone $this;
        $toc->options = $this->options()->merge($wkTocOptions);
        return $toc;
    }

    public function options()
    {
        return $this->options;
    }
}