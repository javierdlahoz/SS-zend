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
	        	'role' => $user->getType(),
                'account' => $user->getAccount(),
                'name' => $user->getName()
        	);
	}

}

