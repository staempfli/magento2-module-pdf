<?php
namespace Staempfli\Pdf\Service;

use \ArrayObject;
use Staempfli\Pdf\Api\Options;

/**
 * Constants are provided for convenience. For a full list of options, see
 * http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
 */
final class PdfOptions extends ArrayObject implements Options
{
    // system wide options
    const KEY_BINARY = 'binary';
    const KEY_VERSION9 = 'version9';
    const KEY_TMP_DIR = 'tmpDir';
    const KEY_IGNORE_WARNINGS = 'ignoreWarnings';
    const KEY_CLI_OPTIONS = 'commandOptions';
    const CLI_OPTIONS_KEY_ESCAPE_ARGS = 'escapeArgs';
    const CLI_OPTIONS_KEY_USE_EXEC = 'useExec';
    const CLI_OPTIONS_KEY_USE_XVFB_RUN = 'enableXvfb';
    const CLI_OPTIONS_KEY_XVFB_RUN_BINARY = 'xvfbRunBinary';
    const CLI_OPTIONS_KEY_XVFB_RUN_OPTIONS = 'xvfbRunOptions';
    /*
     * for more CLI options, see public properties of
     *
     *   \mikehaertl\shellcommand\Command
     */

    // file wide options
    const KEY_TITLE = 'title';
    const KEY_PAGE_SIZE = 'page-size';
    const KEY_PAGE_HEIGHT = 'page-height';
    const KEY_PAGE_WIDTH = 'page-width';
    const KEY_ORIENTATION = 'orientation';
    /**
     * Bottom margin in mm (default 10)
     */
    const KEY_MARGIN_BOTTOM = 'margin-bottom';
    /**
     * Left margin in mm (default 10)
     */
    const KEY_MARGIN_LEFT = 'margin-left';
    /**
     * Right margin in mm (default 10)
     */
    const KEY_MARGIN_RIGHT = 'margin-right';
    /**
     * Top margin in mm (default 10)
     */
    const KEY_MARGIN_TOP = 'margin-top';
    /**
     * HTML header, should be URL or filename
     */
    const KEY_HEADER_HTML_URL = 'header-html';
    /**
     * Header text printed in the top margin (not visible if margin is 0)
     */
    const KEY_HEADER_TEXT_LEFT = 'header-left';
    /**
     * Header text printed in the top margin (not visible if margin is 0)
     */
    const KEY_HEADER_TEXT_RIGHT = 'header-right';
    /**
     * Spacing between header and content in mm (default 0)
     */
    const KEY_HEADER_SPACING = 'header-spacing';
    const FLAG_HEADER_LINE = 'header-line';
    /**
     * HTML footer, should be URL or filename
     */
    const KEY_FOOTER_HTML_URL = 'footer-html';
    /**
     * Footer text printed in the bottom margin (not visible if margin is 0)
     */
    const KEY_FOOTER_TEXT_LEFT = 'footer-left';
    /**
     * Footer text printed in the bottom margin (not visible if margin is 0)
     */
    const KEY_FOOTER_TEXT_RIGHT = 'footer-right';
    /**
     * Spacing between footer and content in mm (default 0)
     */
    const KEY_FOOTER_SPACING = 'footer-spacing';
    const FLAG_FOOTER_LINE = 'footer-line';
    const KEY_HEADER_FOOTER_REPLACE_MAP = 'replace';

    // html page wide options
    const KEY_RUN_SCRIPTS = 'run-script';
    const KEY_COOKIES = 'cookie';
    const KEY_ENCODING = 'encoding';
    const FLAG_NO_OUTLINE = 'no-outline';

    // option values
    const PAGE_SIZE_DIN_A4 = 'A4';
    const PAGE_SIZE_LETTER = 'letter';
    const ORIENTATION_PORTRAIT = 'Portrait';
    const ORIENTATION_LANDSCAPE = 'Landscape';
    const ENCODING_UTF_8 = 'UTF-8';

    /**
     * PdfOptions constructor.
     *
     * Overridden from ArrayObject for default input parameter. This prevents error
     *
     *     Passed variable is not an array or object, using empty array instead
     *
     * while used with Magento 2 object manager
     *
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     */
    public function __construct($input = [], $flags = 0, $iterator_class = \ArrayIterator::class)
    {
        parent::__construct($input, $flags, $iterator_class);
    }


    /**
     * @param Options $newOptions
     * @return PdfOptions
     */
    public function merge(Options $newOptions)
    {
        $merged = clone $this;
        foreach ($newOptions as $key => $value) {
            $merged[$key] = $value;
        }
        return $merged;
    }

    public function asArray()
    {
        return (array) $this;
    }

}