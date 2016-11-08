<?php
namespace Staempfli\Pdf\Api;

use \ArrayObject;

final class WkOptions extends ArrayObject implements Options
{
    const KEY_PAGE_SIZE = 'page-size';

    const PAGE_SIZE_DIN_A4 = 'A4';
    const PAGE_SIZE_LETTER = 'letter';

    public function merge(Options $newOptions)
    {
        // TODO: Implement merge() method.
    }

}