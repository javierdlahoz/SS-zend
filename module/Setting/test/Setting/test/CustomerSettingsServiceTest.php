<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/20/14
 * Time: 5:48 PM
 */

namespace Setting\Test;

use Setting\Service\CustomerSettingsService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use tests\Bootstrap;

error_reporting(0);

class CustomerSettingsServiceTest extends AbstractHttpControllerTestCase{

    private $customerSettingService;
    const ACCOUNT_ID = "dee3c";

    public function setUp()
    {
        parent::setUp();
        $this->customerSettingService = new CustomerSettingsService(Bootstrap::getServiceManager());
    }

    public function testCreateByAccountId()
    {
        $this->customerSettingService->createByAccountId(self::ACCOUNT_ID);
        $customerSettings = $this->customerSettingService->getByAccountId(self::ACCOUNT_ID);

        $this->assertNotNull($customerSettings);
    }

    public function testDeleteByAccountId()
    {
        $this->customerSettingService->deleteByAccountId(self::ACCOUNT_ID);
        $customerSettings = $this->customerSettingService->getCustomFieldsByAccountId(self::ACCOUNT_ID);

        $this->assertCount(0, $customerSettings);
    }

} 