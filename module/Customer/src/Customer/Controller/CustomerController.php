<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 4:05 PM
 */

namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use User\Helper\UserHelper;
use Customer\Facade\CustomerFacade;
use Application\Helper\RequestHelper;

class CustomerController extends AbstractRestfulController
{
    public function countAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $customerService = $this->getServiceLocator()->get('customerService');
            $customerService->setEntity($customerService::PROFILE.$user->getAccount());

            $count = $customerService->getCustomerCount();
            return new JsonModel(array("customerCount" => $count));
        }
    }

    public function mostActiveAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $result = $this->getServiceLocator()->get('customerService')->getMostActive($user->getAccount());
            foreach($result as $customer)
            {
               $mostActives[]  = array(
                    "customer" => CustomerFacade::getCustomerData(
                            $this->getServiceLocator()->get('customerService')
                                ->getCustomerByCode($customer['code'], $user->getAccount())),
                    "transactions" => $customer['times']
               );
            }
            return new JsonModel($mostActives);
        }
    }

    public function thisMonthAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $result = $this->getServiceLocator()->get('customerService')->getCustomersThisMonth($user->getAccount());
            return new JsonModel(array("customerCount" => $result));
        }
    }

    public function lastCustomersAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $customerNumber = $this->getRequest()->getPost()->get('customerNumber');
            $result = $this->getServiceLocator()->get('customerService')->getLastCustomers($customerNumber, $user->getAccount());

            return new JsonModel(CustomerFacade::formatLastCustomers($result));
        }
    }

    public function lookupAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $findText = $this->getRequest()->getPost()->get('query');
            $customers = $this->getServiceLocator()->get('customerService')->getByText($findText, $user->getAccount());

            return new JsonModel(CustomerFacade::formatCustomerCollection($customers));

        }

    }

    public function addAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $this->getServiceLocator()->get('customerService')->add($this->getRequest()->getPost(), $user->getAccount());
            return new JsonModel(array('message' => "Customer added succesfully"));
        }
    }
}