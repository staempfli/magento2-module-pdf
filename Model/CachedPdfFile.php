<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Model;

use Staempfli\Pdf\Api\PdfFile;

/**
 * Class for PDF files loaded from file cache
 */
class CachedPdfFile implements PdfFile
{
    /**
     * CachedPdfFile constructor.
     *
     * @param $pathToCachedFile
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) // https://phpmd.org/rules/index.html
     */
    public function __construct($pathToCachedFile)
    {
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) // https://phpmd.org/rules/index.html
     */
    public function saveAs($path)
    {
        // TODO: Implement saveAs() method.
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        // TODO: Implement send() method.
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        // TODO: Implement toString() method.
    }
}
