<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 27/12/2018
 * Time: 22:08
 */

namespace App\BackManager;


use App\Entity\Action;

class ActionManager
{

    /**
     * @return Action
     */
    public function initAction()
    {
        $action = new Action();
        return $action;
    }


}