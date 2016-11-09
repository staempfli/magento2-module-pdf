<?php
namespace Staempfli\Pdf\Test\Unit\Api;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use Staempfli\Pdf\Api\FakeGeneratedPdf;

class FakeGeneratedPdfTest extends \PHPUnit_Framework_TestCase
{
    /** @var FakeGeneratedPdf */
    private $fakeGeneratedPdf;

    protected function setUp()
    {
        $this->fakeGeneratedPdf = new FakeGeneratedPdf();
        $this->assertFalse($this->fakeGeneratedPdf->isSent());
    }

    public function testSend()
    {
        $this->fakeGeneratedPdf->send();
        $this->assertTrue($this->fakeGeneratedPdf->isSent(), 'isSend flag should be set');
    }

    public function testToString()
    {
        $this->fakeGeneratedPdf->contents = 'this is a PDF';
        $this->assertEquals('this is a PDF', $this->fakeGeneratedPdf->toString());
    }

    public function testSaveAs()
    {
        $this->fakeGeneratedPdf->contents = 'save this totally real PDF';
        $vfsRoot = vfsStream::setUp('root');
        $this->fakeGeneratedPdf->saveAs(vfsStream::url('root/out.pdf'));
        $this->assertTrue($vfsRoot->hasChild('out.pdf'), 'file should be created');
        $this->assertInstanceOf(vfsStreamFile::class, $vfsRoot->getChild('out.pdf'));
        $this->assertEquals('save this totally real PDF', $vfsRoot->getChild('out.pdf')->getContent());
    }
}
