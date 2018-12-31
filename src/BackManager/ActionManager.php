<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 27/12/2018
 * Time: 22:08
 */

namespace App\BackManager;


use App\Entity\Action;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActionManager
{

    public function initAction()
    {
        $action = new Action();
        return $action;
    }


}