<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Service;

use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\PdfEngine;

/**
 * Fake implementation to be used in tests
 */
class FakePdfEngine implements PdfEngine
{
    /**
     * @var \Staempfli\Pdf\Test\Service\FakePdfFile
     */
    public $fakePdfFile;

    /**
     * @var \Staempfli\Pdf\Api\Options
     */
    public $globalOptions;

    /**
     * @var array [string, Options]
     */
    public $cover;

    /**
     * @var \Staempfli\Pdf\Api\Options
     */
    public $tableOfContents;

    /**
     * @var array[] array of pages as [string, Options]
     */
    public $pages = [];

    /**
     * Fake Pdf Engine constructor.
     */
    public function __construct()
    {
        $this->fakePdfFile = new FakePdfFile();
    }

    /**
     * {@inheritdoc}
     */
    public function addPage($html, Options $options)
    {
        $this->pages[] = [$html, $options];
    }

    /**
     * {@inheritdoc}
     */
    public function addCover($html, Options $options)
    {
        $this->cover = [$html, $options];
    }

    /**
     * {@inheritdoc}
     */
    public function addTableOfContents(Options $options)
    {
        $this->tableOfContents = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePdf(Options $globalOptions)
    {
        $this->globalOptions = $globalOptions;
        $this->fakePdfFile->isGenerated = true;

        return $this->fakePdfFile;
    }
}
