<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use User\Helper\PictureHelper;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    /**
     * @return array|JsonModel
     */
    public function indexAction()
    {
        return new JsonModel(array('message' => 'success'));
    }

    /**
     * @return JsonModel
     */
    public function agencyLogoAction()
    {
        $accountId = $this->getRequest()->getPost()->get('agency');
        $pictureUpload = new PictureHelper();
        return new JsonModel(array('pictureUrl' =>
            $pictureUpload->getPictureUrlFromAccount($accountId)));
    }
}
