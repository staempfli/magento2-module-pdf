<?php
namespace Staempfli\Pdf\Api;


final class NullToc implements TableOfContents
{
    public function withOptions(Options $options)
    {
        return $this;
    }

    public function options()
    {
        return new WkOptions([]);
    }

}