<?php
/**
 * Copyright © 2018 Stämpfli AG, All rights reserved.
 */
namespace Staempfli\Pdf\Test\Unit\Service;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use Staempfli\Pdf\Test\Service\FakePdfFile;

class FakePdfFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Staempfli\Pdf\Test\Service\FakePdfFile
     */
    private $fakePdfFile;

    public function testSend()
    {
        $this->fakePdfFile->send();
        $this->assertTrue($this->fakePdfFile->isSent(), 'isSend flag should be set');
    }

    public function testToString()
    {
        $this->fakePdfFile->contents = 'this is a PDF';
        $this->assertEquals('this is a PDF', $this->fakePdfFile->toString());
    }

    public function testSaveAs()
    {
        $this->fakePdfFile->contents = 'save this totally real PDF';
        $vfsRoot = vfsStream::setUp('root');
        $this->fakePdfFile->saveAs(vfsStream::url('root/out.pdf'));
        $this->assertTrue($vfsRoot->hasChild('out.pdf'), 'file should be created');
        $this->assertInstanceOf(vfsStreamFile::class, $vfsRoot->getChild('out.pdf'));
        $this->assertEquals('save this totally real PDF', $vfsRoot->getChild('out.pdf')->getContent());
    }

    protected function setUp()
    {
        $this->fakePdfFile = new FakePdfFile();
        $this->assertFalse($this->fakePdfFile->isSent());
    }
}
