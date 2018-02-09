<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Block;

use Magento\Framework\View\Element\Template;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\OptionsFactory as PdfOptionsFactory;
use Staempfli\Pdf\Api\SourceDocument;

/**
 * A PdfTemplate instance can be passed as source document to the methods:
 *
 *   \Staempfli\Pdf\Service\Pdf::appendContent()
 *   \Staempfli\Pdf\Service\Pdf::appendCover()
 *
 * By default it uses the container template,
 * so that it renders all children. The children do not need to be PdfTemplates,
 * they can be any Magento blocks.
 *
 * If you want to use the full Magento layout with HTML head (CSS, JS),
 * use PdfResult instead (a Magento controller result that also implements SourceDocument)
 */
class PdfTemplate extends Template implements SourceDocument
{
    /**
     * @var string
     */
    protected $_template = 'Magento_Theme::html/container.phtml';

    /**
     * @var \Staempfli\Pdf\Api\Options
     */
    protected $pdfOptions;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Staempfli\Pdf\Api\OptionsFactory $optionsFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PdfOptionsFactory $optionsFactory,
        array $data = []
    ) {
        $this->pdfOptions = $optionsFactory->create();
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function printTo(Medium $medium)
    {
        $medium->printHtml($this->toHtml(), $this->pdfOptions);
    }
}
