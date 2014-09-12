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
    public function thisMonthAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if(UserHelper::isMerchant($user))
        {
            $count = $this->getServiceLocator()->get('transactionService')
                        ->getThisMonthTransactions($user->getAccount());
            return new JsonModel(array("thisMonthTransactions" => $count));
        }
    }

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
}