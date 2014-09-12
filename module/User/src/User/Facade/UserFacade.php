<?php

namespace User\Facade;

class UserFacade
{
    /**
     * @param $user
     * @return array
     */
    public function get($user)
    {
        return array(
        		'username' => $user->getUsername(),
	        	'type' => $user->getType(),
                //'email' => $user->getEmail()
                'account' => $user->getAccount(),
                'name' => $user->getName()
        	);
	}

}

