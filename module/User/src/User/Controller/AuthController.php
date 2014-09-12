<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Application\Facade\ApplicationFacade;
use User\Auth\LoginAdapter;
use Zend\View\Model\JsonModel;
use User\Facade\UserFacade;

class AuthController extends AbstractRestfulController
{

    public function getList(){
        return new JsonModel(ApplicationFacade::getSuccessResponse());
    }

    /**
     * POST request. Params => username, password.
     * @return JsonModel
     */
    public function loginAction()
    {
        $adapter = $this->getServiceLocator()->get('loginAdapter');
		$user = $adapter->login($this->getRequest()->getPost());

		return new JsonModel(UserFacade::get($user));
	}

    /**
     * GET request
     * @return JsonModel
     */
    public function logoutAction()
    {
		$adapter = $this->getServiceLocator()->get('loginAdapter');
		$adapter->logout();

        return new JsonModel(array("message" => "Logout completed."));
	}

}