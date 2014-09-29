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
use Application\Helper\RequestHelper;

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
}