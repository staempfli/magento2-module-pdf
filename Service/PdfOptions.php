<?php
namespace Staempfli\Pdf\Service;

use \ArrayObject;
use Staempfli\Pdf\Api\Options;

/**
 * Constants are provided for convenience and documentation. For an up to date full list of options, see
 * http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
 *
 * GLOBAL options can only be set for the full document
 * PAGE options can be set for the full document and overridden per page
 * TOC options can only be set for the table of contents
 *
 * FLAGs have to be provided as single value, KEYs as key=>value pair. Example:
 *
 * [
 *     PdfOptions::FLAG_PAGE_PRINT_MEDIA_TYPE,
 *     PdfOptions::KEY_PAGE_NUMBER_OFFSET => -1,
 * ]
 *
 */
final class PdfOptions extends ArrayObject implements Options
{
    // global options
    const KEY_GLOBAL_BINARY = 'binary';
    const KEY_GLOBAL_VERSION9 = 'version9';
    const KEY_GLOBAL_TMP_DIR = 'tmpDir';
    const KEY_GLOBAL_IGNORE_WARNINGS = 'ignoreWarnings';
    /**
     * Additional CLI options, as array. See KEY_CLI_OPTIONS_* constants
     *
     * For more CLI options, refer to the public properties of
     *
     *   \mikehaertl\shellcommand\Command
     */
    const KEY_GLOBAL_CLI_OPTIONS = 'commandOptions';

    const KEY_CLI_OPTIONS_ESCAPE_ARGS = 'escapeArgs';
    const KEY_CLI_OPTIONS_USE_EXEC = 'useExec';
    const KEY_CLI_OPTIONS_USE_XVFB_RUN = 'enableXvfb';
    const KEY_CLI_OPTIONS_XVFB_RUN_BINARY = 'xvfbRunBinary';
    const KEY_CLI_OPTIONS_XVFB_RUN_OPTIONS = 'xvfbRunOptions';

    /**
     * The title of the generated pdf file (The title of the first document is used if not specified)
     */
    const KEY_GLOBAL_TITLE = 'title';
    /**
     * Set paper size to: A4, Letter, etc. (default A4)
     */
    const KEY_GLOBAL_PAGE_SIZE = 'page-size';
    /**
     * Page height in mm, can be used instead of PAGE_SIZE for more control
     */
    const KEY_GLOBAL_PAGE_HEIGHT = 'page-height';
    /**
     * Page width in mm, can be used instead of PAGE_SIZE for more control
     */
    const KEY_GLOBAL_PAGE_WIDTH = 'page-width';
    /**
     * Set orientation to Landscape or Portrait (default Portrait)
     */
    const KEY_GLOBAL_ORIENTATION = 'orientation';
    /**
     * Bottom margin in mm (default 10)
     */
    const KEY_GLOBAL_MARGIN_BOTTOM = 'margin-bottom';
    /**
     * Left margin in mm (default 10)
     */
    const KEY_GLOBAL_MARGIN_LEFT = 'margin-left';
    /**
     * Right margin in mm (default 10)
     */
    const KEY_GLOBAL_MARGIN_RIGHT = 'margin-right';
    /**
     * Top margin in mm (default 10)
     */
    const KEY_GLOBAL_MARGIN_TOP = 'margin-top';
    /**
     * Put an outline (bookmarks) into the pdf (default)
     */
    const FLAG_GLOBAL_OUTLINE = 'outline';
    /**
     * Do not put an outline (bookmarks) into the pdf
     */
    const FLAG_GLOBAL_NO_OUTLINE = 'no-outline';
    /**
     * Set the depth of the outline (default 4)
     */
    const KEY_GLOBAL_OUTLINE_DEPTH = 'outline-depth';
    /**
     * Collate when printing multiple copies (default)
     */
    const FLAG_GLOBAL_COLLATE = 'collate';
    /**
     * Do not collate when printing multiple copies
     */
    const FLAG_GLOBAL_NO_COLLATE = 'no-collate';
    /**
     * Read and write cookies from and to the supplied cookie jar file
     */
    const KEY_GLOBAL_COOKIE_JAR = 'cookie-jar';
    /**
     * Number of copies to print into the pdf file (default 1)
     */
    const KEY_GLOBAL_COPIES = 'copies';
    /**
     * PDF will be generated in grayscale
     */
    const FLAG_GLOBAL_GRAYSCALE = 'grayscale';
    /**
     * When embedding images scale them down to this dpi (default 600)
     */
    const KEY_GLOBAL_IMAGE_DPI = 'image-dpi';
    /**
     * When jpeg compressing images use this quality (default 94)
     */
    const KEY_GLOBAL_IMAGE_QUALITY = 'image-quality';
    /**
     * Generates lower quality pdf/ps. Useful to shrink the result document space
     */
    const FLAG_GLOBAL_LOWQUALITY = 'lowquality';
    /**
     * Do not use lossless compression on pdf objects
     */
    const FLAG_GLOBAL_NO_PDF_COMPRESSION = 'no-pdf-compression';

    // page options
    /**
     * HTML header, should be URL or filename
     */
    const KEY_PAGE_HEADER_HTML_URL = 'header-html';
    /**
     * Header text printed in the top margin (not visible if margin is 0)
     */
    const KEY_PAGE_HEADER_TEXT_LEFT = 'header-left';
    /**
     * Header text printed in the top margin (not visible if margin is 0)
     */
    const KEY_PAGE_HEADER_TEXT_RIGHT = 'header-right';
    /**
     * Spacing between header and content in mm (default 0)
     */
    const KEY_PAGE_HEADER_SPACING = 'header-spacing';
    /**
     * Display line below the header
     */
    const FLAG_PAGE_HEADER_LINE = 'header-line';
    /**
     * Do not display line below the header (default)
     */
    const FLAG_PAGE_NO_HEADER_LINE = 'no-header-line';
    /**
     * Centered header text
     */
    const KEY_PAGE_HEADER_CENTER = 'header-center';
    /**
     * Set header font name (default Arial)
     */
    const KEY_PAGE_HEADER_FONT_NAME = 'header-font-name';
    /**
     * Set header font size (default 12)
     */
    const KEY_PAGE_HEADER_FONT_SIZE = 'header-font-size';
    /**
     * HTML footer, should be URL or filename
     */
    const KEY_PAGE_FOOTER_HTML_URL = 'footer-html';
    /**
     * Footer text printed in the bottom margin (not visible if margin is 0)
     */
    const KEY_PAGE_FOOTER_TEXT_LEFT = 'footer-left';
    /**
     * Footer text printed in the bottom margin (not visible if margin is 0)
     */
    const KEY_PAGE_FOOTER_TEXT_RIGHT = 'footer-right';
    /**
     * Spacing between footer and content in mm (default 0)
     */
    const KEY_PAGE_FOOTER_SPACING = 'footer-spacing';
    /**
     * Display line above the footer
     */
    const FLAG_PAGE_FOOTER_LINE = 'footer-line';
    /**
     * Do not display line above the footer (default
     */
    const FLAG_PAGE_NO_FOOTER_LINE = 'no-footer-line';
    /**
     * Centered footer text
     */
    const KEY_PAGE_FOOTER_CENTER = 'footer-center';
    /**
     * Set footer font name (default Arial)
     */
    const KEY_PAGE_FOOTER_FONT_NAME = 'footer-font-name';
    /**
     * Set footer font size (default 12)
     */
    const KEY_PAGE_FOOTER_FONT_SIZE = 'footer-font-size';
    /**
     * Array of additional replacements. ["foo" => "bar"] will replace "[foo]" with "bar"
     */
    const KEY_PAGE_HEADER_FOOTER_REPLACE_MAP = 'replace';
    /**
     * Run these additional javascript after the page is done loading (array of JS files)
     */
    const KEY_PAGE_RUN_SCRIPTS = 'run-script';
    /**
     * Set additional cookies (array of URL encoded values)
     */
    const KEY_PAGE_COOKIES = 'cookie';
    /**
     * Set the default text encoding
     */
    const KEY_PAGE_ENCODING = 'encoding';
    /**
     * Use print media-type instead of screen
     */
    const FLAG_PAGE_PRINT_MEDIA_TYPE = 'print-media-type';
    /**
     * Do not use print media-type instead of screen (default)
     */
    const FLAG_PAGE_NO_PRINT_MEDIA_TYPE = 'no-print-media-type';
    /**
     * HTTP Authentication username
     */
    const KEY_PAGE_HTTP_AUTH_USER = 'username';
    /**
     * HTTP Authentication password
     */
    const KEY_PAGE_HTTP_AUTH_PASSWORD = 'password';
    /**
     * Allowed conversion of a local file to read in other local files. (default)
     */
    const FLAG_PAGE_ENABLE_LOCAL_FILE_ACCESS = 'enable-local-file-access';
    /**
     * Do not allow conversion of a local file to read in other local files,
     * unless explicitly allowed with FLAG_PAGE_ALLOW
     */
    const FLAG_PAGE_DISABLE_LOCAL_FILE_ACCESS = 'disable-local-file-access';
    /**
     * Allow the file or files from the specified folder to be loaded (array of paths)
     */
    const FLAG_PAGE_ALLOW = 'allow';
    /**
     * Adjust the starting page number (default 0)
     */
    const KEY_PAGE_NUMBER_OFFSET = 'page-offset';

    /**
     * Do print background (default)
     */
    const FLAG_PAGE_BACKGROUND = 'background';
    /**
     * Do not print background
     */
    const FLAG_PAGE_NO_BACKGROUND = 'no-background';
    /**
     * Web cache directory
     */
    const KEY_PAGE_CACHE_DIR = 'cache-dir';
    /**
     * Use this SVG file when rendering checked checkboxes
     */
    const KEY_PAGE_CHECKBOX_CHECKED_SVG = 'checkbox-checked-svg';
    /**
     * Use this SVG file when rendering unchecked checkboxes
     */
    const KEY_PAGE_CHECKBOX_SVG = 'checkbox-svg';
    /**
     * <value>  Set additional HTTP headers (array with names as keys and values as values)
     */
    const KEY_PAGE_CUSTOM_HEADER = 'custom-header';
    /**
     * Add HTTP headers specified by KEY_PAGE_CUSTOM_HEADER for each resource request.
     */
    const FLAG_PAGE_CUSTOM_HEADER_PROPAGATION = 'custom-header-propagation';
    /**
     * Do not add HTTP headers specified by KEY_PAGE_CUSTOM_HEADER for each resource request.
     */
    const FLAG_PAGE_NO_CUSTOM_HEADER_PROPAGATION = 'no-custom-header-propagation';
    /**
     * Show javascript debugging output
     */
    const FLAG_PAGE_DEBUG_JAVASCRIPT = 'debug-javascript';
    /**
     * Do not show javascript debugging output (default)
     */
    const FLAG_PAGE_NO_DEBUG_JAVASCRIPT = 'no-debug-javascript';
    /**
     * Add a default header, with the name of the page to the left, and the page number to the right, this is short for:
     *  --header-left='[webpage]'
     *  --header-right='[page]/[toPage]'
     *  --top 2cm
     *  --header-line
     */
    const FLAG_PAGE_DEFAULT_HEADER = 'default-header';
    /**
     * Do not make links to remote web pages
     */
    const FLAG_PAGE_DISABLE_EXTERNAL_LINKS = 'disable-external-links';
    /**
     * Make links to remote web pages (default)
     */
    const FLAG_PAGE_ENABLE_EXTERNAL_LINKS = 'enable-external-links';
    /**
     * Do not turn HTML form fields into pdf form fields (default)
     */
    const FLAG_PAGE_DISABLE_FORMS = 'disable-forms';
    /**
     * Turn HTML form fields into pdf form fields
     */
    const FLAG_PAGE_ENABLE_FORMS = 'enable-forms';
    /**
     * Do load or print images (default)
     */
    const FLAG_PAGE_IMAGES = 'images';
    /**
     * Do not load or print images
     */
    const FLAG_PAGE_NO_IMAGES = 'no-images';
    /**
     * Do not make local links
     */
    const FLAG_PAGE_DISABLE_INTERNAL_LINKS = 'disable-internal-links';
    /**
     * Make local links (default)
     */
    const FLAG_PAGE_ENABLE_INTERNAL_LINKS = 'enable-internal-links';
    /**
     * Do not allow web pages to run javascript
     */
    const FLAG_PAGE_DISABLE_JAVASCRIPT = 'disable-javascript';
    /**
     * Do allow web pages to run javascript (default)
     */
    const FLAG_PAGE_ENABLE_JAVASCRIPT = 'enable-javascript';
    /**
     * Wait some milliseconds for javascript finish (default 200)
     */
    const KEY_PAGE_JAVASCRIPT_DELAY = 'javascript-delay';
    /**
     * Specify how to handle pages that fail to load: abort, ignore or skip (default abort)
     */
    const KEY_PAGE_LOAD_ERROR_HANDLING = 'load-error-handling';
    /**
     * Specify how to handle media files that fail to load: abort, ignore or skip (default ignore)
     */
    const KEY_PAGE_LOAD_MEDIA_ERROR_HANDLING = 'load-media-error-handling';
    /**
     * Minimum font size
     */
    const KEY_PAGE_MINIMUM_FONT_SIZE = 'minimum-font-size';
    /**
     * Do not include the page in the table of contents and outlines
     */
    const FLAG_PAGE_EXCLUDE_FROM_OUTLINE = 'exclude-from-outline';
    /**
     * Include the page in the table of contents  and outlines (default)
     */
    const FLAG_PAGE_INCLUDE_IN_OUTLINE = 'include-in-outline';
    /**
     * Disable installed plugins (default)
     */
    const FLAG_PAGE_DISABLE_PLUGINS = 'disable-plugins';
    /**
     * Enable installed plugins (plugins will likely not work)
     */
    const FLAG_PAGE_ENABLE_PLUGINS = 'enable-plugins';
    /**
     * Add additional post fields (array)
     */
    const KEY_PAGE_POST = 'post';
    /**
     * Post additional files (array of paths)
     */
    const KEY_PAGE_POST_FILE = 'post-file';
    /**
     * Use a proxy
     */
    const KEY_PAGE_PROXY = 'proxy';
    /**
     * Use this SVG file when rendering checked radiobuttons
     */
    const KEY_PAGE_RADIOBUTTON_CHECKED_SVG = 'radiobutton-checked-svg';
    /**
     * Use this SVG file when rendering unchecked radiobuttons
     */
    const KEY_PAGE_RADIOBUTTON_SVG = 'radiobutton-svg';
    /**
     * Disable the intelligent shrinking strategy used by WebKit that makes the pixel/dpi ratio none constant
     */
    const FLAG_PAGE_DISABLE_SMART_SHRINKING = 'disable-smart-shrinking';
    /**
     * Enable the intelligent shrinking strategy used by WebKit that makes the pixel/dpi ratio none constant (default)
     */
    const FLAG_PAGE_ENABLE_SMART_SHRINKING = 'enable-smart-shrinking';
    /**
     * Stop slow running javascripts (default)
     */
    const FLAG_PAGE_STOP_SLOW_SCRIPTS = 'stop-slow-scripts';
    /**
     * Do not Stop slow running javascripts
     */
    const FLAG_PAGE_NO_STOP_SLOW_SCRIPTS = 'no-stop-slow-scripts';
    /**
     * Do not link from section header to toc (default)
     */
    const FLAG_PAGE_DISABLE_TOC_BACK_LINKS = 'disable-toc-back-links';
    /**
     * Link from section header to toc
     */
    const FLAG_PAGE_ENABLE_TOC_BACK_LINKS = 'enable-toc-back-links';
    /**
     * Specify a user style sheet, to load with every page
     */
    const KEY_PAGE_USER_STYLE_SHEET = 'user-style-sheet';
    /**
     * Set viewport size if you have custom scrollbars or css attribute overflow to emulate window size
     */
    const KEY_PAGE_VIEWPORT_SIZE = 'viewport-size';
    /**
     * Wait until window.status is equal to this string before rendering page
     */
    const KEY_PAGE_WINDOW_STATUS = 'window-status';
    /**
     * Use this zoom factor (default 1)
     */
    const KEY_PAGE_ZOOM = 'zoom';

    // toc options
    /**
     * The header text of the toc (default "Table of Contents")
     */
    const KEY_TOC_HEADER_TEXT = 'toc-header-text';
    /**
     * Use the supplied xsl style sheet for printing the table of content
     */
    const KEY_TOC_XSL_STYLE_SHEET = 'xsl-style-sheet';
    /**
     * For each level of headings in the toc indent by this length (default 1em)
     */
    const FLAG_TOC_LEVEL_INDENTATION = 'toc-level-indentation';
    /**
     * Do not use dotted lines in the toc
     */
    const FLAG_TOC_DISABLE_DOTTED_LINES = 'disable-dotted-lines';
    /**
     * Do not link from toc to sections
     */
    const FLAG_TOC_DISABLE_LINKS = 'disable-toc-links';

    // option values
    const PAGE_SIZE_DIN_A4 = 'A4';
    const PAGE_SIZE_LETTER = 'letter';
    const ORIENTATION_PORTRAIT = 'Portrait';
    const ORIENTATION_LANDSCAPE = 'Landscape';
    const ENCODING_UTF_8 = 'UTF-8';
    const LOAD_ON_ERROR_ABORT = 'abort';
    const LOAD_ON_ERROR_IGNORE = 'ignore';
    const LOAD_ON_ERROR_SKIP = 'skip';
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
     * @param string $iteratorClass
     */
    public function __construct($input = [], $flags = 0, $iteratorClass = \ArrayIterator::class)
    {
        parent::__construct($input, $flags, $iteratorClass);
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