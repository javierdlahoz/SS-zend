<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/20/14
 * Time: 5:48 PM
 */

namespace Setting\Test;

use Setting\Service\SettingService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Setting\Entity\Setting;
use tests\Bootstrap;

class SettingTest extends AbstractHttpControllerTestCase{

    private $settingService;
    const ACCOUNT_ID = "testMozido";
    const CUSTOM_LANGUAGE = "{id: 1}";

    public function setUp()
    {
        parent::setUp();
        $this->settingService = new SettingService(Bootstrap::getServiceManager());
    }

    public function testCreateByAccountId()
    {
        $this->settingService->createByAccountId(self::ACCOUNT_ID);
        $settings = $this->settingService->getByAccountId(self::ACCOUNT_ID);
        $settings = $settings[0];

        $this->assertEquals($settings->getAccountId(), self::ACCOUNT_ID);
        $this->assertEquals($settings->getCurrencyGlyph(), "$");
    }

    public function testCreateCustomLanguage()
    {
        $this->settingService->saveCustomLanguage(self::ACCOUNT_ID, self::CUSTOM_LANGUAGE);
        $customLanguage = $this->settingService->getCustomLanguage(self::ACCOUNT_ID);

        $this->assertEquals($customLanguage->getAccountId(), self::ACCOUNT_ID);
        $this->assertEquals($customLanguage->getCustomLanguage(), self::CUSTOM_LANGUAGE);
    }

    public function testDeleteCustomLanguage()
    {
        $this->settingService->deleteCustomLanguage(self::ACCOUNT_ID);
        $customLanguage = $this->settingService->getCustomLanguage(self::ACCOUNT_ID);

        $this->assertNull($customLanguage);
    }

    public function testDeleteByAccountId()
    {
        $this->settingService->deleteByAccountId(self::ACCOUNT_ID);
        $settings = $this->settingService->getByAccountId(self::ACCOUNT_ID);

        $this->assertCount(0, $settings);
    }

} 