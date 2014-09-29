<?php

namespace User\Helper;

use User\Entity\User;
use Zend\View\Model\JsonModel;

class UserHelper
{
    const ACCOUNT = "account";

    private $serviceLocator;

    function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param mixed $serviceLocator
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function isLoggedIn($user)
    {
        if(empty($user))
        {
            throw new \Exception('User is not logged in');
        }

        return true;
    }

    /**
     * @param $user
     * @throws \Exception
     * @return bool|JsonModel
     */
    public function isMerchant($user)
    {
        if(($user instanceof User) && ($user->getType() == self::ACCOUNT) && ($user != null))
        {
            return true;
        }
        else
        {
            throw new \Exception("You don't have permission to access this functionality");
        }
    }

    public function getApiCredentials($user)
    {
        $accounts = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager')
                        ->getRepository('User\Entity\AccountUser')->findBy(array('account_id' => $user->getAccount()));

        $account = $accounts[0];
        return array(
            "userId" => $user->getUsername(),
            "token" => $account->getApiToken(),
            "accountId" => $user->getAccount()
        );
    }
}