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