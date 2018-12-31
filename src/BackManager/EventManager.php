<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 31/12/2018
 * Time: 01:44
 */

namespace App\BackManager;


use App\Entity\Event;

class EventManager
{
    public function initEvent()
    {
        $event = new Event;

        return $event;
    }
}