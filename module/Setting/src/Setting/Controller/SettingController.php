<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 4:05 PM
 */

namespace Setting\Controller;

use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Setting\Facade\SettingFacade;
use Setting\Facade\CustomerSettingFacade;
use Application\Helper\RequestHelper;
use Setting\Facade\CampaignSettingsFacade;
use User\Helper\UserHelper;

class SettingController extends AbstractRestfulController
{
    /**
     * @return JsonModel
     */
    public function loadAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $this->getServiceLocator()->get('userHelper')->isLoggedIn($user);

        $settings = $this->getServiceLocator()->get('settingService')->getByAccountId($user->getAccount());
        if(empty($settings))
        {
            $this->getServiceLocator()->get('settingService')->createByAccountId($user->getAccount());
            $settings = $this->getServiceLocator()->get('settingService')->getByAccountId($user->getAccount());
        }

        return new JsonModel(SettingFacade::formatSettings($settings[0]));
    }

    /**
     * @return JsonModel
     */
    public function updateAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $this->getServiceLocator()->get('userHelper')->isLoggedIn($user);

        $confirmation = $this->getServiceLocator()->get('settingService')->editByAccountId($user->getAccount(), $this->getRequest()->getPost());

        if($confirmation)
        {
            return new JsonModel(array("message" => "Settings updated successfully"));
        }
    }

    /**
     * @return JsonModel
     */
    public function loadCustomerSettingsAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $this->getServiceLocator()->get('userHelper')->isLoggedIn($user);

        $customerSetting = $this->getServiceLocator()->get('customerSettingService')->getByAccountId($user->getAccount());
        if(empty($customerSetting))
        {
            $this->getServiceLocator()->get('customerSettingService')->createByAccountId($user->getAccount());
            $customerSetting = $this->getServiceLocator()->get('customerSettingService')->getByAccountId($user->getAccount());
        }

        return new JsonModel(CustomerSettingFacade::formatCustomerSettings($customerSetting));
    }

    /**
     * @return JsonModel
     */
    public function updateCustomerSettingsAction()
    {

        $user = $this->zfcUserAuthentication()->getIdentity();
        $this->getServiceLocator()->get('userHelper')->isLoggedIn($user);

        $confirmation = $this->getServiceLocator()->get('customerSettingService')->editByAccountId($user->getAccount(), $this->getRequest()->getPost());

        if($confirmation)
        {
            return new JsonModel(array("message" => "Settings updated successfully"));
        }
    }

    /**
     * @throws \Exception
     */
    public function setLogoAction()
    {
        if(RequestHelper::isPost($this->getRequest()))
        {
            var_dump($_FILES);
            die();
            $files = $this->getRequest()->getFiles();
            var_dump($files);
            die();
        }
    }

    /**
     * @return JsonModel
     */
    public function loadCampaignSettingsAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $campaignSettings = $this->getServiceLocator()->get('campaignSettingsService')->getSettingsByCampaign($user->getAccount());
            return new JsonModel(CampaignSettingsFacade::formatCampaignSettingsCollection($campaignSettings));
        }
    }

    /**
     * @return JsonModel
     * @throws \Exception
     */
    public function updateCampaignSettingsAction()
    {
        $campaignSettings = json_decode($this->getRequest()->getContent());
        $this->getServiceLocator()->get('campaignSettingsService')->saveCampaignSettings($campaignSettings);

        return new JsonModel(array('message' => "Settings updated successfully"));
    }

    /**
     * @return array|null
     * @throws \Exception
     */
    public function loadLanguageAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $accountId = $user->getAccount();
            $customLanguage = $this->getServiceLocator()->get('settingService')->getCustomLanguage($accountId);

            return new JsonModel(SettingFacade::formatCustomLanguage($customLanguage));
        }
    }

    /**
     * @return JsonModel
     * @throws \Exception
     */
    public function updateLanguageAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        //if(UserHelper::isMerchant($user))
        //{
            $accountId = $user->getAccount();

            $customLanguage = $this->getRequest()->getContent();
            $this->getServiceLocator()->get('settingService')->saveCustomLanguage($accountId, $customLanguage);

            return new JsonModel(array("message" => "Language updated successfully"));
        //}
    }

}