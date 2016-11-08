<?php
namespace Staempfli\Pdf\Api;


final class FakeGeneratedPdf implements GeneratedPdf
{
    /** @var string */
    private $contents;
    /** @var bool */
    private $isGenerated = false;
    /** @var bool */
    private $isSent = false;

    /**
     * @param string $contents
     */
    public function __construct($contents = '')
    {
        $this->contents = $contents;
    }

    public function saveAs($path)
    {
        // TODO: Implement saveAs() method.
    }

    public function send()
    {
        // TODO: Implement send() method.
    }

    public function toString()
    {
        // TODO: Implement toString() method.
    }
}