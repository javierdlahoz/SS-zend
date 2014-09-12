<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/12/14
 * Time: 11:22 AM
 */

namespace Application\Helper;

class RequestHelper
{

    public function isPost($request)
    {
        if($request->isPost())
        {
            return true;
        }
        else
        {
            throw new \Exception('Bad Request');
        }
    }
}