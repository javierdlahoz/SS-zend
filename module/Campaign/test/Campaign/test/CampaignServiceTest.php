<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/20/14
 * Time: 5:48 PM
 */

namespace Campaign\Test;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use tests\Bootstrap;
use Campaign\Service\CampaignService;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

error_reporting(0);

class CampaignServiceTest extends AbstractHttpControllerTestCase{

    private $campaignService;
    private $request;

    const ACCOUNT_ID = "Agua_Cristal";
    const TEXT_TO_LOOK_FOR = "a";
    const CUSTOMER_CODE = '8656056326304770';
    const CAMPAIGN_ID = '8028791047981467';
    const CUSTOMER_LIMIT = 5;
    const ENTITY = "profiles_agua_cristal";

    const FIRST_NAME = "Eusebio";
    const LAST_NAME = "EusebioMan";
    const NEW_LAST_NAME = "MozidoTestingMan";

    public function setUp()
    {
        parent::setUp();
        $this->campaignService = new CampaignService(Bootstrap::getServiceManager());

        $this->request = new Request();
        $this->request->setMethod("POST");
    }

    public function testGetActiveCampaigns()
    {
        $activeCampaigns = $this->campaignService->getActiveCampaigns(self::ACCOUNT_ID);
        $this->assertArrayHasKey('campaign_id', $activeCampaigns[0]);
    }

    public function testGetDailyVolumeAllCampaigns()
    {
        $dailyVolume = $this->campaignService->getDailyVolumeAllCampaigns(self::ACCOUNT_ID);
        $this->dailyVolume = $dailyVolume[0];

        $this->assertNotNull($dailyVolume[0]["valuePerDay"]);

    }

    public function testGetType()
    {
        $type = $this->campaignService->getType(self::CAMPAIGN_ID);
        $this->assertEquals("T", $type);
    }

    public function testGetPromotions()
    {
        $promotions = $this->campaignService->getPromotions(self::CAMPAIGN_ID);
        if($promotions != null)
        {
            $this->assertInstanceOf('Campaign\Entity\Promotion\Promotion', $promotions[0]);
        }
    }

    public function testGetMultipliers()
    {
        $multipliers = $this->campaignService->getMultipliers(self::CAMPAIGN_ID);
        if($multipliers != null)
        {
            $this->assertInstanceOf('Campaign\Entity\Promotion\Promotion', $multipliers[0]);
        }
    }

    public function testGetRewards()
    {
        $rewards = $this->campaignService->getRewards(self::CAMPAIGN_ID);
        if($rewards != null)
        {
            $this->assertArrayHasKey('description', $rewards[0]);
        }
    }

}