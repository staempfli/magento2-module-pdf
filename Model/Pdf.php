<?php
namespace Staempfli\Pdf\Model;

use \mikehaertl\wkhtmlto\Pdf as Wkhtmltopdf;
use \Magento\Framework\Filesystem\Io\File;

class Pdf
{
    const ORIENTATION_PORTRAIT = 'Portrait';
    const ORIENTATION_LANDSCAPE = 'Landscape';

    const SIZE_A4 = 'A4';
    const SIZE_LETTER = 'letter';

    /**
     * @var Wkhtmltopdf
     */
    protected $pdf;

    /**
     * @var File
     */
    protected $file;


    /**
     * Cache Lifetime
     * @var int
     */
    private $lifetime = 0;

    /**
     * Pdf constructor.
     * @param Wkhtmltopdf $pdf
     * @param File $file
     */
    public function __construct(
        Wkhtmltopdf $pdf,
        File $file
    )
    {
        $this->pdf = $pdf;
        $this->file = $file;
        $this->setOrientation(self::ORIENTATION_PORTRAIT);
        $this->setPageSize(self::SIZE_A4);
    }

    /**
     * @param $directory
     * @return $this
     * @throws \Exception
     */
    public function setStorageDirectory($directory)
    {
        if($this->file->checkAndCreateFolder($directory)) {
            $this->pdf->tmpDir = $directory;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getStorageDirectory()
    {
        return $this->pdf->tmpDir;
    }

    /**
     * @return int
     */
    public function getCacheLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param $lifetime
     * @return $this
     */
    public function setCacheLifetime($lifetime)
    {
        if(is_numeric($lifetime)) {
            $this->lifetime = $lifetime;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isCacheEnabled()
    {
        if ($this->lifetime > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param $filename
     * @return bool
     */
    public function isFileInCache($filename)
    {
        if($this->file->fileExists($this->getStorageDirectory() . DIRECTORY_SEPARATOR . $filename, true)) {
            // @codingStandardsIgnoreStart
            return !(filemtime($this->getStorageDirectory() . DIRECTORY_SEPARATOR . $filename) + $this->getCacheLifetime()) < time();
            // @codingStandardsIgnoreEnd
        }
        return false;
    }

    /**
     * @param string $orientation
     * @return $this
     */
    public function setOrientation($orientation = self::ORIENTATION_PORTRAIT)
    {
        $this->pdf->setOptions(['orientation' => $orientation]);
        return $this;
    }

    /**
     * @param string $size
     * @return $this
     */
    public function setPageSize($size = self::SIZE_A4)
    {
        $this->pdf->setOptions(['page-size' => $size]);
        return $this;
    }

    /**
     * @param $toc
     * @return $this
     */
    public function addToc($toc)
    {
        $this->pdf->addToc($toc);
        return $this;
    }

    /**
     * @param $cover
     * @return $this
     */
    public function addCover($cover)
    {
        $this->pdf->addCover($cover);
        return $this;
    }

    /**
     * @param mixed $page
     * @return $this
     */
    public function addPage($page)
    {
        $this->pdf->addPage($page);
        return $this;
    }

    /**
     * @param $header
     * @return $this
     */
    public function addHeader($header)
    {
        if (is_string($header)) {
            $this->pdf->setOptions(array('header-html' => $header));
        }
        return $this;
    }

    /**
     * @param mixed $footer
     * @return $this
     */
    public function addFooter($footer)
    {
        if (is_string($footer)) {
            $this->pdf->setOptions(array('footer-html' => $footer));
        }
        return $this;
    }

    /**
     * @param string $filename
     * @param bool $download
     * @param bool $inline
     * @return bool
     */
    public function storePdf($filename = '', $download = false, $inline = false)
    {
        $tmpDir = $this->pdf->tmpDir;

        if ($this->isCacheEnabled()
            && $this->file->fileExists($tmpDir . DIRECTORY_SEPARATOR . $filename)
            && $download === true) {

            // @codingStandardsIgnoreStart
            if ($this->isFileInCache($filename)) {
                header('Pragma: public');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Content-Type: application/pdf');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: '.filesize($tmpDir . DIRECTORY_SEPARATOR . $filename));

                if ($filename!==null || $inline) {
                    $disposition = $inline ? 'inline' : 'attachment';
                    header("Content-Disposition: $disposition; filename=\"$filename\"");
                }

                readfile($tmpDir . DIRECTORY_SEPARATOR . $filename);
                return true;
            }
            // @codingStandardsIgnoreEnd
        }

        if ($download) {
            $this->pdf->send($filename, $inline);
        } else {
            $this->pdf->saveAs($filename);
        }

        // Save temporary file
        $tmpFile = $this->pdf->getPdfFilename();
        if ($this->file->mv($tmpFile, $tmpDir . DIRECTORY_SEPARATOR . $filename)) {
            return true;
        }
        return false;
    }

    /**
     * @param null $filename
     */
    public function savePdf($filename = null)
    {
        $this->storePdf($filename);
    }

    /**
     * @param null $filename
     * @param bool $inline
     */
    public function downloadPdf($filename = null, $inline = false)
    {
        $this->storePdf($filename, true, $inline);
    }
}
