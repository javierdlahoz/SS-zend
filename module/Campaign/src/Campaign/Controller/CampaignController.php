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
use Application\Helper\RequestHelper;
use Customer\Facade\BalanceFacade;
use Campaign\Facade\Item\ItemFacace;

class CampaignController extends AbstractRestfulController
{
    /**
     * @return JsonModel
     */
    public function listAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $campaignsSQLResult = $this->getServiceLocator()->get('campaignService')->getActiveCampaigns($user->getAccount());
            return new JsonModel(CampaignFacade::formatCampaignList($campaignsSQLResult));
        }
    }

    /**
     * @return JsonModel
     */
    public function dailyVolumeAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $dailyVolumes = $this->getServiceLocator()->get('campaignService')->getDailyVolumeAllCampaigns($user->getAccount());
            return new JsonModel($dailyVolumes);
        }
    }

    /**
     * @return JsonModel
     */
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

    /**
     * @return JsonModel
     */
    public function balanceAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $campaignId = $this->getRequest()->getPost()->get('campaignId');
            $customerCode = $this->getRequest()->getPost()->get('customerCode');

            $customerAdapter = $this->getServiceLocator()->get('customerAdapter');
            $customerAdapter->setUser($user);

            return new JsonModel(BalanceFacade::formatBalance($customerAdapter->getBalance($customerCode, $campaignId)));
        }
    }

    /**
     * @return JsonModel
     */
    public function rewardsAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $campaignId = $this->getRequest()->getPost()->get('campaignId');
            return new JsonModel($this->getServiceLocator()->get('campaignService')->getRewards($campaignId));
        }
    }

    /**
     * @return JsonModel
     */
    public function itemsAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $campaignId = $this->getRequest()->getPost()->get('campaignId');
            $campaignService = $this->getServiceLocator()->get('campaignService');

            return new JsonModel(ItemFacace::formatItemCollection($campaignService->getBuyXRewards($campaignId)));
        }
    }
}