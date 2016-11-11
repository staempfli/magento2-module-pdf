<?php
namespace Staempfli\Pdf\Model;

class Cache
{
    const CACHE_TAG = 'STAEMPFLI_PDF';

    /** @var \Zend_Cache_Backend */
    private $cacheBackend;

    public function save($cacheKey)
    {
        //TODO implement
    }
    public function load($cacheKey)
    {
        //TODO implement
    }
}