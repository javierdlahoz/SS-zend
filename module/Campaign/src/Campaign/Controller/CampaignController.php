<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 4:05 PM
 */

namespace Campaign\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use User\Helper\UserHelper;
use Campaign\Facade\CampaignFacade;
use Campaign\Facade\Promotion\PromotionFacade;

class CampaignController extends AbstractRestfulController
{
    public function listAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $campaignsSQLResult = $this->getServiceLocator()->get('campaignService')->getActiveCampaigns($user->getAccount());
            return new JsonModel(CampaignFacade::formatCampaignList($campaignsSQLResult));
        }
    }

    public function dailyVolumeAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $dailyVolumes = $this->getServiceLocator()->get('campaignService')->getDailyVolumeAllCampaigns($user->getAccount());
            return new JsonModel($dailyVolumes);
        }
    }

    public function promotionsAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $campaignId = $this->getRequest()->getPost()->get('campaignId');
            $promotions = $this->getServiceLocator()->get('campaignService')->getPromotions($campaignId);

            return new JsonModel(PromotionFacade::formatPromotionCollection($promotions));
        }
    }

}