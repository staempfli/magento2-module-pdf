<?php
namespace Staempfli\Pdf\Test\Integration;

use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\Response;
use Magento\TestFramework\TestCase\AbstractBackendController;

class ConfigTest extends  AbstractBackendController
{
    /** @var  Response */
    private static $lastResponse;
    /** @var  ObjectManager */
    protected $objectManager;

    public static function tearDownAfterClass()
    {
        self::$lastResponse = null;
    }

    private function setUpRequest()
    {
        $this->uri = 'backend/admin/system_config/edit';
        $this->resource = 'Staempfli_Pdf::config_staempfli_pdf';
        $this->getRequest()->setParam('section', 'staempfli_pdf');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
        $this->setUpRequest();
    }
    /**
     * Overridden to make depends annotation work
     */
    public function testAclHasAccess()
    {
        parent::testAclHasAccess();
        // we do not pass the response as parameter to dependent test because PHPUnit would take ages
        // to go through the object tree, looking for mock objects.
        self::$lastResponse = $this->getResponse();
    }
    /**
     * Overridden to check for redirect instead of "Forbidden" response
     */
    public function testAclNoAccess()
    {
        if ($this->resource === null) {
            $this->markTestIncomplete('Acl test is not complete');
        }
        $this->_objectManager->get('Magento\Framework\Acl\Builder')
            ->getAcl()
            ->deny(null, $this->resource);
        $this->dispatch($this->uri);
        $this->assertSame(302, $this->getResponse()->getHttpResponseCode());
        $this->assertContains('/index.php/backend/admin/system_config/index/', $this->getResponse()->getHeader('location')->toString());
    }
    /**
     * @depends testAclHasAccess
     */
    public function testConfigSectionLoads()
    {
        $response = self::$lastResponse;
        $this->assertEquals(200, $response->getStatusCode(), 'HTTP Status Code');
    }
}