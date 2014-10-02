<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/1/14
 * Time: 5:08 PM
 */

namespace Application\Controller;

use User\Helper\PictureHelper;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class AgencyController extends AbstractRestfulController{

    /**
     * @return JsonModel
     */
    public function logoAction()
    {
        $accountId = $this->getRequest()->getPost()->get('agencyToken');
        $pictureUpload = new PictureHelper();
        return new JsonModel(array('pictureUrl' =>
            $pictureUpload->getPictureUrlFromAccount($accountId)));
    }

    /**
     * @return JsonModel
     */
    public function validateAction()
    {
        $accountId = $this->getRequest()->getPost()->get('agencyToken');
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $accounts = $entityManager->getRepository('User\Entity\Account')->findBy(array('username' => $accountId));

        if(count($accounts) > 0)
        {
            return new JsonModel(array("isAgency" => true));
        }
        else
        {
            return new JsonModel(array("isAgency" => false));
        }
    }
} 