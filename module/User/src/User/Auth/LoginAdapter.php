<?php

namespace User\Auth;

use User\Entity\User;
use Zend\Http\PhpEnvironment\Request;
use Zend\Stdlib\Parameters;

class LoginAdapter extends AbstractAdapter implements IAdapter
{
    /**
     * @return mixed
     */
    private function getEntityManager()
    {
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        return $entityManager;
    }

    /**
     * @param $request
     * @return User
     * @throws \Exception
     */
    public function signup($request)
    {
        $serviceZfc = $this->getServiceLocator()->get('zfcuser_user_service');

        $post = array(
            "username" => $request['username'],
            "password" => $request['password'],
            "passwordVerify" => $request['password']
           // "email" => $request['email']
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
        $entityManager->merge($user);
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
            throw new \Exception(json_encode($errors));
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

		$params = new Parameters();
		$params->set('identity', $request->get('username'));
		$params->set('credential', $request->get('password'));
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
            if($this->isRegistered($request))
            {
                throw new \Exception('Please, check your credentials');
            }

            $accountUser = $this->getAccountUsersByParams($params);
            if($accountUser != null)
            {
                return $this->createUserFromAccountUsers($accountUser);
            }

            $account = $this->getAccountByParams($params);
            if($account != null)
            {
                return $this->createUserFromAccount($account);
            }

        	$result = $auth->getMessages();
			$message = "Bad request.";

            if(isset($result[0])) {
				$message = $result[0];
			}

            throw new \Exception($message);
        }
        $user = $this->getAuthPlugin()->getIdentity();
		
		return $user;
	}

    /**
     * @param $request
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function changePassword($request, $user)
    {
        $form = $this->getChangePasswordForm();
        $prg = array(
            "identity" => $user->getEmail(),
            "credential" => $request->get('currentPassword'),
            "newCredential" => $request->get('newPassword'),
            "newCredentialVerify" => $request->get('newPasswordVerify'),
            "submit" => "Submit"
            );

        $form->setData($prg);

        if (!$form->isValid()) {
        	$errors = $form->getMessages();
            throw new \Exception("Check the fields");
        }

        $zfcUserService = $this->getServiceLocator()->get('zfcuser_user_service');
        if (!$zfcUserService->changePassword($form->getData())) {
            $errors = $form->getMessages();
            throw new \Exception("Current password doesn't match");
        }
        return true;
	}

    /**
     * @param $params
     * @return null
     * @throws \Exception
     */
    private function getAccountByParams($params)
    {
        $entityManager = $this->getEntityManager();
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
     * @param $account
     * @throws \Exception
     * @return User
     */
    private function createUserFromAccount($account)
    {
        $request = array(
            'username' => $account->getUsername(),
            'password' => $account->getPassword(),
            'type' => "account",
            'name' => $account->getName(),
            'account' => $account->getAccountId()
        );

        return $this->signup($request);
    }

    /**
     * @param $params
     * @return null
     * @throws \Exception
     */
    private function getAccountUsersByParams($params)
    {
        $entityManager = $this->getEntityManager();
        $accounts = $entityManager->getRepository('User\Entity\AccountUser')->findBy(array('username' => $params['identity']));

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
     * @param $account
     * @throws \Exception
     * @return User
     */
    private function createUserFromAccountUsers($account)
    {
        if($account->getRole() != "A")
        {
            throw new \Exception("You don't have enought priveleges to use this app");
        }

        $request = array(
            'username' => $account->getUsername(),
            'password' => $account->getPassword(),
            //'email' => $account->getContactEmail(),
            'type' => "account",
            'name' => $account->getFirstname()." ".$account->getLastname(),
            'account' => $account->getAccountId()
        );

        return $this->signup($request);
    }

    /**
     * @param $request
     * @return bool
     */
    private function isRegistered($request)
    {
        $entityManager = $this->getEntityManager();
        $users = $entityManager->getRepository('User\Entity\User')->findBy(array('username' => $request->get('username')));

        if(empty($users))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function logout()
    {
		parent::logout();
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
    private function getLoginForm()
    {
		return $this->getServiceLocator()->get('zfcuser_login_form');
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
