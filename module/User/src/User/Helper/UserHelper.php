<?php

namespace User\Helper;

use Application\Service\AbstractService;
use User\Entity\User;
use Zend\View\Model\JsonModel;

class UserHelper
{
    const ADMIN = "A";
    const MANAGER = "M";

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
        if(($user instanceof User) && ($user != null))
        {
            return true;
        }
        else
        {
            throw new \Exception("You don't have permission to access this functionality");
        }
    }

    /**
     * @param $user
     * @throws \Exception
     */
    public function isAdminOrManager($user)
    {
        if(($user instanceof User) && ($user->getType() == self::ADMIN || $user->getType() == self::MANAGER) && ($user != null))
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
        $accounts = $this->getServiceLocator()->get(AbstractService::STICKY_STREET_ENTITY_MANAGER)
                        ->getRepository('User\Entity\Account')->findBy(array('username' => $user->getAccount()));

        $accountUser = $this->getServiceLocator()->get(AbstractService::STICKY_STREET_ENTITY_MANAGER)
            ->getRepository('User\Entity\AccountUser')
                ->findOneBy(
                    array('account_id' => $user->getAccount(),
                            'role' => "A"
                    ));

        $account = $accounts[0];
        return array(
            "userId" => $accountUser->getUsername(),
            "token" => $account->getApiToken(),
            "accountId" => $user->getAccount()
        );
    }
}