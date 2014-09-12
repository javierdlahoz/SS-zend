<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 4:05 PM
 */

namespace Setting\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Setting\Facade\SettingFacade;
use Setting\Facade\CustomerSettingFacade;

class SettingController extends AbstractRestfulController
{

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
}