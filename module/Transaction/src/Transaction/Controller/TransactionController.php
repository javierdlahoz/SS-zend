<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 4:05 PM
 */

namespace Transaction\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use User\Helper\UserHelper;
use Transaction\Facade\TransactionFacade;
use Application\Helper\RequestHelper;

class TransactionController extends AbstractRestfulController
{
    /**
     * @return JsonModel
     */
    public function thisMonthAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $customerCode = $this->getRequest()->getPost()->get('customerCode');

            if($customerCode == null)
            {
                $count = $this->getServiceLocator()->get('transactionService')
                    ->getThisMonthTransactions($user->getAccount());
            }
            else
            {
                $count = $this->getServiceLocator()->get('transactionService')
                    ->getThisMonthTransactionsByCustomer($customerCode, $user->getAccount());
            }

            return new JsonModel(array("thisMonthTransactions" => $count));
        }
    }

    /**
     * @return JsonModel
     */
    public function lastTransactionsAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $transactionNumber = $this->getRequest()->getPost()->get('transactionNumber');
            $result = $this->getServiceLocator()->get('transactionService')
                        ->getLastTransaction($transactionNumber, $user->getAccount());

            return new JsonModel(TransactionFacade::formatLastTransactions($result));
        }
    }

    /**
     * @return JsonModel
     */
    public function historyAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $campaignId = $this->getRequest()->getPost()->get('campaignId');
            $code = $this->getRequest()->getPost()->get('code');

            $transactionHistory = $this->getServiceLocator()->get('transactionService')
                        ->getByCodeAndCampaignId($code, $campaignId, $user->getAccount());

            return new JsonModel(TransactionFacade::formatTransactionCollection($transactionHistory));
        }
    }

    /**
     * @return JsonModel
     */
    public function redeemAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $campaignId = $this->getRequest()->getPost()->get('campaignId');
            $code = $this->getRequest()->getPost()->get('code');
            $rewardId = $this->getRequest()->getPost()->get('rewardId');
            $points = $this->getRequest()->getPost()->get('points');
            $dollars = $this->getRequest()->getPost()->get('dollars');
            $authorization = $this->getRequest()->getPost()->get('authorization');

            $transactionAdapter = $this->getServiceLocator()->get('transactionAdapter');
            $transactionAdapter->setUser($user);

            if($transactionAdapter->redeem($code, $campaignId, $rewardId, $points, $dollars, $authorization))
            {
                return new JsonModel(array('message' => 'Transaction successfully done'));
            }
        }
    }

    /**
     * @return JsonModel
     */
    public function recordAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user) && (RequestHelper::isPost($this->getRequest())))
        {
            $customerCode = $this->getRequest()->getPost()->get('customerCode');
            $campaignId = $this->getRequest()->getPost()->get('campaignId');
            $amount = $this->getRequest()->getPost()->get('amount');
            $sendEmail = $this->getRequest()->getPost()->get('customerCode');

            if($sendEmail ==  true)
            {
                $sendEmail = "Y";
            }
            $serviceProduct = $this->getRequest()->getPost()->get('serviceProduct');
            $buyXQty = $this->getRequest()->getPost()->get('buyXQty');
            $promoId = $this->getRequest()->getPost()->get('promoId');
            $authorization = $this->getRequest()->getPost()->get('authorization');

            $transactionAdapter = $this->getServiceLocator()->get('transactionAdapter');
            $transactionAdapter->setUser($user);

            if($transactionAdapter->record($customerCode, $campaignId, $amount,
                       $sendEmail, $serviceProduct, $buyXQty, $promoId, $authorization))
            {
                return new JsonModel(array('message' => 'Transaction successfully done'));
            }
        }
    }

    public function lastByCustomerAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $customerCode = $this->getRequest()->getPost()->get('customerCode');

            if($customerCode != null)
            {
                $transactions = $this->getServiceLocator()->get('transactionService')
                    ->getLastTransactionByCustomer($customerCode, $user->getAccount());
            }
            return new JsonModel(TransactionFacade::formatLastTransactionByCustomer($transactions));
        }
    }

}