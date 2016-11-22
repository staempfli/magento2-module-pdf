<?php
namespace Staempfli\Pdf\Block;

use Magento\Framework\View\Element\Template;
use Staempfli\Pdf\Api\OptionsFactory as PdfOptionsFactory;

/*
 * http://magento.stackexchange.com/questions/146883/how-to-reuse-magento2-head-block
 *
 * Usage:
 *  - direct instantiation (outside of layout)
 *  - create and define root block for output:
 *             $layout->addContainer('main', 'Main Container');
 *             $layout->addOutputElement('main');
 *  - add children
 *  - pass PdfFullLayout instance to Pdf service
 */
use Magento\Framework\View\Page\Config;

class PdfFullLayout extends PdfTemplate
{
    protected $_template = 'Magento_Theme::root.phtml';
    /**
     * @var Config
     */
    protected $pageConfig;
    /**
     * @todo replace with specialized renderer (similar to \Magento\Developer\Model\View\Page\Config\ClientSideLessCompilation\Renderer)
     * @var \Magento\Framework\View\Page\Config\RendererInterface
     */
    protected $pageConfigRenderer;
    /**
     * @var Config\RendererFactory
     */
    protected $pageConfigRendererFactory;

    public function __construct(Template\Context $context, PdfOptionsFactory $optionsFactory, Config $pageConfig,
                                Config\RendererFactory $pageConfigRendererFactory, array $data = [])
    {
        parent::__construct($context, $optionsFactory);
        $this->pageConfig = $pageConfig;
        $this->pageConfigRendererFactory = $pageConfigRendererFactory;
        $this->pageConfigRenderer = $this->pageConfigRendererFactory->create(['pageConfig' => $this->pageConfig]);
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }


    protected function _beforeToHtml()
    {
        $config = $this->getConfig();
        $addBlock = $this->getLayout()->getBlock('head.additional');
        $requireJs = $this->getLayout()->getBlock('require.js');
        $this->assign([
            'requireJs' => $requireJs ? $requireJs->toHtml() : null,
            'headContent' => $this->pageConfigRenderer->renderHeadContent(),
            'headAdditional' => $addBlock ? $addBlock->toHtml() : null,
            'htmlAttributes' => $this->pageConfigRenderer->renderElementAttributes($config::ELEMENT_TYPE_HTML),
            'headAttributes' => $this->pageConfigRenderer->renderElementAttributes($config::ELEMENT_TYPE_HEAD),
            'bodyAttributes' => $this->pageConfigRenderer->renderElementAttributes($config::ELEMENT_TYPE_BODY),
            'loaderIcon' => $this->getViewFileUrl('images/loader-2.gif'),
        ]);

        $output = $this->getLayout()->getOutput();
        $this->assign('layoutContent', $output);

        return parent::_beforeToHtml();
    }

    /**
     * Return page configuration
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->pageConfig;
    }
    /**
     * Add default body classes for current page layout
     *
     * @return $this
     */
    protected function addDefaultBodyClasses()
    {
        $this->pageConfig->addBodyClass($this->_request->getFullActionName('-'));
        $pageLayout = $this->getPageLayout();
        if ($pageLayout) {
            $this->pageConfig->addBodyClass('page-layout-' . $pageLayout);
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function getPageLayout()
    {
        return $this->pageConfig->getPageLayout() ?: $this->getLayout()->getUpdate()->getPageLayout();
    }
}