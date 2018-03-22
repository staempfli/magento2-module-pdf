<?php
namespace Staempfli\Pdf\Model;

use Magento\Framework\App\Response\HttpInterface as HttpResponseInterface;
use Staempfli\Pdf\Api\Medium;
use Staempfli\Pdf\Api\Options;
use Staempfli\Pdf\Api\OptionsFactory as PdfOptionsFactory;
use Staempfli\Pdf\Api\SourceDocument;

/**
 * A Magento response,
 * used by the framework to render HTML (ResponseInterface) and by the PDF service to print it (SourceDocument).
 *
 * HTTP response must be created separately if desired
 * (the PdfResult controller result implementation can be used for this)
 */
final class PdfResponse implements HttpResponseInterface, SourceDocument
{
    private $body;
    /** @var  Options */
    private $pdfOptions;

    const PARAM_OPTIONS = 'options';
    public function __construct(Options $options)
    {
        $this->pdfOptions = $options;
    }

    /**
     * We don't actually send a HTTP response, the PdfResponse instance is sent to the Pdf service instead
     *
     * @return void
     */
    public function sendResponse()
    {
        return;
    }

    /**
     * Not explicitly part of the Response interface but implicitly required by \Magento\Framework\View\Result\Page
     *
     * @param string $value
     * @return $this
     */
    public function appendBody($value)
    {
        $this->body .= $value;
        return $this;
    }

    /**
     * @param Medium $medium
     */
    public function printTo(Medium $medium)
    {
        $medium->printHtml($this->body, $this->pdfOptions);
    }

    /**
     * Set HTTP response code
     *
     * @param int $code
     * @return void
     */
    public function setHttpResponseCode($code)
    {
    }

    /**
     * Get HTTP response code
     *
     * @return int
     */
    public function getHttpResponseCode()
    {
        return 200;
    }

    /**
     * Set a header
     *
     * If $replace is true, replaces any headers already defined with that $name.
     *
     * @param string $name
     * @param string $value
     * @param boolean $replace
     * @return self
     */
    public function setHeader($name, $value, $replace = false)
    {
        return $this;
    }

    /**
     * Get header value by name
     *
     * Returns first found header by passed name.
     * If header with specified name was not found returns false.
     *
     * @param string $name
     * @return \Zend\Http\Header\HeaderInterface|bool
     */
    public function getHeader($name)
    {
        return false;
    }

    /**
     * Remove header by name from header stack
     *
     * @param string $name
     * @return self
     */
    public function clearHeader($name)
    {
        return $this;
    }

    /**
     * Allow granular setting of HTTP response status code, version and phrase
     *
     * For example, a HTTP response as the following:
     *     HTTP 200 1.1 Your response has been served
     * Can be set with the arguments
     *     $httpCode = 200
     *     $version = 1.1
     *     $phrase = 'Your response has been served'
     *
     * @param int|string $httpCode
     * @param null|int|string $version
     * @param null|string $phrase
     * @return self
     */
    public function setStatusHeader($httpCode, $version = null, $phrase = null)
    {
        return $this;
    }

    /**
     * Set the response body to the given value
     *
     * Any previously set contents will be replaced by the new content.
     *
     * @param string $value
     * @return self
     */
    public function setBody($value)
    {
        return $this;
    }

    /**
     * Set redirect URL
     *
     * Sets Location header and response code. Forces replacement of any prior redirects.
     *
     * @param string $url
     * @param int $code
     * @return self
     */
    public function setRedirect($url, $code = 302)
    {
        return $this;
    }
}