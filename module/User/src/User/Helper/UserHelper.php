<?php

namespace User\Helper;

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

    public function isMerchant($user)
    {
        if(($user instanceof \User\Entity\User) && ($user->getType() == self::ACCOUNT))
        {
            return true;
        }
        else
        {
            throw new \Exception("You don't have access to this function");
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