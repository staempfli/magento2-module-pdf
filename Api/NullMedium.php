<?php
namespace Staempfli\Pdf\Api;


final class NullMedium implements Medium
{
    public function withHtml($source)
    {
        return $this;
    }

    public function withOptions(Options $options)
    {
        return $this;
    }

    public function html()
    {
        return '';
    }

    public function options()
    {
        return new WkOptions([]);
    }

}