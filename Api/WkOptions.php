<?php
namespace Staempfli\Pdf\Api;

use \ArrayObject;

final class WkOptions extends ArrayObject implements Options
{
    const KEY_PAGE_SIZE = 'page-size';

    const PAGE_SIZE_DIN_A4 = 'A4';
    const PAGE_SIZE_LETTER = 'letter';

    /**
     * @param Options $newOptions
     * @return WkOptions
     */
    public function merge(Options $newOptions)
    {
        $merged = clone $this;
        foreach ($newOptions as $key => $value) {
            $merged[$key] = $value;
        }
        return $merged;
    }

}