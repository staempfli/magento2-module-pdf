<?php
namespace Staempfli\Pdf\Model;

/**
 * Configuration constants, in class for autoloading
 */
class Config
{
    const XML_PATH_BINARY = 'staempfli_pdf/system/binary';
    const XML_PATH_VERSION9 = 'staempfli_pdf/system/version9';
    const XML_PATH_TMP_DIR = 'staempfli_pdf/system/tmp_dir';
    const XML_PATH_IGNORE_WARNINGS = 'staempfli_pdf/system/ignore_warnings';

    const XML_PATH_ESCAPE_ARGS = 'staempfli_pdf/system/escape_args';
    const XML_PATH_USE_EXEC = 'staempfli_pdf/system/use_exec';
    const XML_PATH_USE_XVFB_RUN = 'staempfli_pdf/system/enable_xvfb';
    const XML_PATH_XVFB_RUN_BINARY = 'staempfli_pdf/system/xvfb_run_binary';
    const XML_PATH_XVFB_RUN_OPTIONS = 'staempfli_pdf/system/xvfb_run_options';
}