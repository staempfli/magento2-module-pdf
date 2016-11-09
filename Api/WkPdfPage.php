<?php
namespace Staempfli\Pdf\Api;


final class WkPdfPage implements Medium
{
    /** @var string  */
    private $html = '';
    /** @var Options */
    private $options;

    public function __construct()
    {
        $this->options = new WkOptions();
    }

    public function withHtml($source)
    {
        $page = clone $this;
        $page->html = $source;
        return $page;
    }

    public function withOptions(Options $wkPageOptions)
    {
        $page = clone $this;
        $page->options = $this->options()->merge($wkPageOptions);
        return $page;
    }

    public function html()
    {
        return $this->html;
    }

    public function options()
    {
        return $this->options;
    }

}