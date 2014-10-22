<?php

namespace User\Auth;

use Application\Service\AbstractService;
use User\Entity\User;
use Zend\Http\PhpEnvironment\Request;
use Zend\Stdlib\Parameters;
use User\Entity\AccountUser;

class LoginAdapter extends AbstractAdapter implements IAdapter
{

    const AGENCY_DELETED_MESSAGE = 'The agency has been deleted';
    const CHECK_CREDENTIALS_MESSAGE = 'Please check your credentials';
    /**
     * @return mixed
     */
    private function getEntityManager()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    /**
     * @return mixed
     */
    private function getEntityManagerStickyStreet()
    {
        return $this->getServiceLocator()->get(AbstractService::STICKY_STREET_ENTITY_MANAGER);
    }

    /**
     * @param $request
     * @return User
     * @throws \Exception
     */
    private function signup($request)
    {
        $serviceZfc = $this->getServiceLocator()->get('zfcuser_user_service');

        $post = array(
            "username" => $request['username'],
            "password" => $request['password'],
            "passwordVerify" => $request['password']
        );

        $user  = new User();
        $form  = $this->getRegisterForm();
        $form->setHydrator($this->getFormHydrator());
        $form->bind($user);
        $form->setData($post);

        if(!$form->isValid())
        {
            $errors = $form->getMessages();
            if(isset($errors['email']['recordFound'])) {
                throw new \Exception("This username is already taken.");
            }
            else {
                throw new \Exception(json_encode($errors));
            }
        }

        $user = $serviceZfc->register($post);
        $user->setUsername($request['username']);
        $user->setType($request['type']);
        $user->setName($request['name']);
        $user->setAccount($request['account']);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        if($user)
        {
            $this->getAuthPlugin()->getAuthAdapter()->resetAdapters();
            $this->getAuthPlugin()->getAuthService()->clearIdentity();
            $this->getAuthPlugin()->getAuthService()->getStorage()->write($user);
            return $user;
        }
        else
        {
            throw new \Exception("There's no user");
        }
    }

    /**
     * @param $request
     * @return array|mixed|User
     * @throws \Exception
     */
    public function login($request)
    {
		$adapter = $this->getAuthPlugin()->getAuthAdapter();

        $pin = $request->get('pin');
        $accountId = $request->get('accountId');


        if(!empty($pin))
        {
            $user = $this->getUserByPin($pin, $accountId);
            $credentials =  array(
                'username' => $user->getUsername(),
                'password' => $user->getPassword()
            );
        }
        else {
            $credentials = array(
                'username' => $request->get('username'),
                'password' => $request->get('password')
            );
        }

        $params = new Parameters();
        $params->set('identity', $credentials['username']);
        $params->set('credential', $credentials['password']);
		$emulatedRequest = new Request();
		$emulatedRequest->setPost($params);

        $result = $adapter->prepareForAuthentication($emulatedRequest);

        if ($result instanceof Response)
        {
            return $result;
        }


        $auth = $this->getAuthPlugin()->getAuthService()->authenticate($adapter);
        if(!$auth->isValid())
        {
            $isRegistered = $this->isRegistered($credentials);
            $accountUser = $this->getAccountUsersByParams($params);

            if($accountUser != null && !$isRegistered)
            {
                if($this->getIsDeleted($accountUser->getAccountId()))
                {
                    throw new \Exception(self::AGENCY_DELETED_MESSAGE);
                }

                return $this->createUserFromAccountUsers($accountUser);
            }

            $account = $this->getAccountByParams($params);
            if($account != null && !$isRegistered)
            {
                return $this->createUserFromAccount($account);
            }

            if($accountUser != null && $isRegistered)
            {
                return $this->updateUser($accountUser);
            }

        	$result = $auth->getMessages();
			$message = "Bad request.";

            if(isset($result[0])) {
				$message = $result[0];
			}

            throw new \Exception($message);
        }
        $accountUser = $this->getAccountUsersByParams($params);
        if($this->getIsDeleted($accountUser->getAccountId()))
        {
            throw new \Exception(self::AGENCY_DELETED_MESSAGE);
        }

        $user = $this->getAuthPlugin()->getIdentity();
		
		return $user;
	}


    /**
     * @param $params
     * @return null
     * @throws \Exception
     */
    private function getAccountByParams($params)
    {
        $entityManager = $this->getEntityManagerStickyStreet();
        $accounts = $entityManager->getRepository('User\Entity\Account')->findBy(array('username' => $params['identity']));

        if(!empty($accounts))
        {
            if($accounts[0]->getPassword() == $params['credential'])
            {
                return $accounts[0];
            }
        }
        return null;
    }

    /**
     * @param AccountUser $user
     * @return User
     * @throws \Exception
     */
    private function updateUser(AccountUser $user)
    {
        $entityManager = $this->getEntityManager();
        $userApp = $entityManager->getRepository('User\Entity\User')->findOneBy(array('username' => $user->getUsername()));
        $entityManager->remove($userApp);
        $entityManager->flush($userApp);

        $request = array(
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'type' => $user->getRole(),
            'name' => $user->getFirstname()." ".$user->getLastname(),
            'account' => $user->getAccountId()
        );

        return $this->signup($request);

    }

    /**
     * @param $account
     * @throws \Exception
     * @return User
     */
    private function createUserFromAccount($account)
    {
        $request = array(
            'username' => $account->getUsername(),
            'password' => $account->getPassword(),
            'type' => "A",
            'name' => $account->getName(),
            'account' => $account->getAccountId()
        );

        return $this->signup($request);
    }

    /**
     * @param $params
     * @throws \Exception
     * @internal param $accountId
     * @return null
     */
    private function getAccountUsersByParams($params)
    {
        $entityManager = $this->getEntityManagerStickyStreet();
        $accounts = $entityManager->getRepository('User\Entity\AccountUser')->findBy(array('username' => $params['identity']));

        if(!empty($accounts))
        {
            if($accounts[0]->getPassword() == $params['credential'])
            {
                return $accounts[0];
            }
        }
        else
        {
            throw new \Exception(self::CHECK_CREDENTIALS_MESSAGE);
        }
    }

    /**
     * @param $account
     * @throws \Exception
     * @return User
     */
    private function createUserFromAccountUsers(AccountUser $account)
    {
        $request = array(
            'username' => $account->getUsername(),
            'password' => $account->getPassword(),
            'type' => $account->getRole(),
            'name' => $account->getFirstname()." ".$account->getLastname(),
            'account' => $account->getAccountId()
        );

        return $this->signup($request);
    }

    /**
     * @param $credentials
     * @internal param $request
     * @return bool
     */
    private function isRegistered($credentials)
    {
        $entityManager = $this->getEntityManager();
        $users = $entityManager->getRepository('User\Entity\User')->findBy(array('username' => $credentials['username']));

        if(count($users) == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
		parent::logout();
	}

    /**
     * @param $pin
     * @param $accountId
     * @throws \Exception
     * @return mixed
     */
    private function getUserByPin($pin, $accountId)
    {
        $entityManager = $this->getEntityManagerStickyStreet();
        $users = $entityManager->getRepository('User\Entity\AccountUser')->findBy(array('user_pin' => $pin, 'account_id' => $accountId));

        if(empty($users))
        {
            throw new \Exception(self::CHECK_CREDENTIALS_MESSAGE);
        }

        return $users[0];
    }

    /**
     * @param $accountId
     * @return bool
     */
    private function getIsDeleted($accountId)
    {
        $entityManager = $this->getEntityManagerStickyStreet();
        $agency = $entityManager->getRepository('User\Entity\Account')->findOneBy(array('username' => $accountId));

        if($agency->getAgencyToken() == "deleted")
        {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    private function getRegisterForm()
    {
		return $this->getServiceLocator()->get('zfcuser_register_form');
    }

    /**
     * @return mixed
     */
    private function getFormHydrator()
    {
		return ($this->getServiceLocator()->get('zfcuser_register_form_hydrator'));
    }

    /**
     * @return mixed
     */
    private function getChangePasswordForm()
    {
        return $this->getServiceLocator()->get('zfcuser_change_password_form');
    }

    /**
     * @return mixed
     */
    public function getChangeEmailForm()
    {
        return $this->getServiceLocator()->get('zfcuser_change_email_form');
    }
}
