<?php
namespace Staempfli\Pdf\Api;

/**
 * Options for PDF renderer as traversable hash map
 */
interface Options extends \ArrayAccess, \Traversable
{
    /**
     * Return options merged with other options (overriding existing values).
     *
     * @param Options $newOptions
     * @return Options
     */
    public function merge(Options $newOptions);

    /**
     * Return options as associative array
     *
     * @return array
     */
    public function asArray();
}