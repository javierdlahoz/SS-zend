<?php

namespace User\Helper;

class UserHelper
{
    const ACCOUNT = "account";

    function __contruct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
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
}