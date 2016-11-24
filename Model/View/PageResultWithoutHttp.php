<?php
namespace Staempfli\Pdf\Model\View;

use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;

/**
 * This exposes the render() method of the original Page result object to allow calling it without using
 * renderResult()
 *
 * renderResult() has plugins that expect a Http Response object and throw an error with the Pdf Response and also
 * expects HTTP header related methods that are not part of the ResponseInterface
 */
class PageResultWithoutHttp extends Page
{
    public function renderNonHttpResult(ResponseInterface $response)
    {
        \Magento\Framework\Profiler::start('LAYOUT');
        \Magento\Framework\Profiler::start('layout_render');

        $this->render($response);

        $this->eventManager->dispatch('layout_render_before');
        \Magento\Framework\Profiler::stop('layout_render');
        \Magento\Framework\Profiler::stop('LAYOUT');
        return $this;
    }
}