<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/20/14
 * Time: 5:48 PM
 */

namespace Setting\Test;

use Setting\Service\CampaignSettingsService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use tests\Bootstrap;

error_reporting(0);

class CampaignSettingsServiceTest extends AbstractHttpControllerTestCase{

    private $campaignSettingService;
    const ACCOUNT_ID = "dee3c";

    public function setUp()
    {
        parent::setUp();
        $this->campaignSettingService = new CampaignSettingsService(Bootstrap::getServiceManager());
    }

    public function testGetSettingsByCampaign()
    {
        $campaignSettings = $this->campaignSettingService->getSettingsByCampaign(self::ACCOUNT_ID);
        $this->assertNotNull($campaignSettings);
    }

    public function testDeleteCampaignSettings()
    {
        $this->campaignSettingService->deleteCampaignSettings(self::ACCOUNT_ID);
        $campaignSettings = $this->campaignSettingService->getSettingsByCampaign(self::ACCOUNT_ID, false);

        foreach($campaignSettings as $campaignSetting)
        {
            $this->assertCount(0, $campaignSetting["campaignSettings"]);
        }
    }

} 