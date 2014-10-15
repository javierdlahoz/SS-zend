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
use Customer\Facade\BalanceFacade;
use Customer\Entity\Customer;
use Customer\Facade\CustomFieldFacade;

class CustomerController extends AbstractRestfulController
{
    /**
     * @return JsonModel
     */
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

    /**
     * @return JsonModel
     */
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

    /**
     * @return JsonModel
     */
    public function thisMonthAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $result = $this->getServiceLocator()->get('customerService')->getCustomersThisMonth($user->getAccount());
            return new JsonModel(array("customerCount" => $result));
        }
    }

    /**
     * @return JsonModel
     */
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

    /**
     * @return JsonModel
     */
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

    /**
     * @return JsonModel
     */
    public function addAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $this->getServiceLocator()->get('customerService')->add($this->getRequest()->getPost(), $user);
            return new JsonModel(array('message' => "Customer added succesfully"));
        }
    }

    /**
     * @return JsonModel
     */
    public function balancesAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $customerCode = $this->getRequest()->getPost()->get('customerCode');
            $campaigns = \Campaign\Facade\CampaignFacade::formatCampaignList(
                $this->getServiceLocator()->get('campaignService')->getActiveCampaigns($user->getAccount()));

            $customerAdapter = $this->getServiceLocator()->get('customerAdapter');

            $customerAdapter->setUser($user);
            foreach($campaigns as $campaign)
            {

                $balances[] = $customerAdapter->getBalance($customerCode, $campaign['id']);
            }

            return new JsonModel(BalanceFacade::formatBalanceCollection($balances));
        }
    }

    /**
     * @return JsonModel
     */
    public function editAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $customer = new Customer();
            $customFields = $this->getServiceLocator()->get('customerService')->getCustomFields($user->getAccount());

            $customer->fillFromPost($this->getRequest()->getPost(), $customFields);

            $customerService = $this->getServiceLocator()->get('customerService');
            $customerService->editCustomer($customer, $user->getAccount());

            return new JsonModel(array('message' => "Customer updated successfully"));
        }
    }

    /**
     * @return JsonModel
     * @throws \Exception
     */
    public function customFieldsAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $customFields = $this->getServiceLocator()->get('customerService')->getCustomFields($user->getAccount());
            return new JsonModel(CustomFieldFacade::formatCustomFieldCollection($customFields));
        }
    }
}