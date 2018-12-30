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
    const SESSION_ACTION_KEY = "SessionKey";
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * ActionManager constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {

        $this->session = $session;
    }

    public function initAction()
    {
        $action = new Action();
        $this->session->set(self::SESSION_ACTION_KEY, $action);
        return $action;
    }

    public function myCurrentAction()
    {
        $action = $this->session->get(self::SESSION_ACTION_KEY);
        if ($action instanceof Action) {
            return $action;
        } else {
            throw new NotFoundHttpException();
        }
    }


}