<?php

namespace User\Controller;

use Zend\Config\Writer\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use User\Facade\UserFacade;
use User\Helper\PictureHelper;

class ProfileController extends AbstractRestfulController
{
    /**
     * POST Request. Params => currentPassword, newPassword, newPasswordVerify
     * @throws \Exception
     * @return JsonModel
     */
    public function changePasswordAction()
    {
		$isPost = $this->getRequest()->isPost();
        $user = $this->zfcUserAuthentication()->getIdentity();

		if(($isPost)&&($this->getServiceLocator()->get('userHelper')->isLoggedIn($user)))
        {
            $adapter = $this->getServiceLocator()->get('loginAdapter');
			$adapter->changePassword( $this->getRequest()->getPost(), $user);

			return new JsonModel(array("message" => "Password changed."));
        }
        else
        {
            throw new \Exception('Bad Request');
        }
	}

    /**
     * GET Request
     * @return mixed|JsonModel
     */
    public function getList()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        if($this->getServiceLocator()->get('userHelper')->isLoggedIn($user))
        {
            return new JsonModel(UserFacade::get($user));
        }
    }

    /**
     * @return JsonModel
     * @throws \Exception
     */
    public function pictureAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $isPost = $this->getRequest()->isPost();
        $pictureUpload = new PictureHelper();

        if($isPost)
        {
            $file = $this->getRequest()->getFiles();
            $pictureUpload->addPictureFromRequest($file, $user->getAccount());

            return new JsonModel(array('message' => 'Picture uploaded'));
        }
        else
        {
            return new JsonModel(array('pictureUrl' =>
                $pictureUpload->getPictureUrlFromAccount($user->getAccount())));
        }
    }

}