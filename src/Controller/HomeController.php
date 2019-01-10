<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 19/12/2018
 * Time: 01:38
 */

namespace App\Controller;


use App\Repository\ActionRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var ActionRepository
     */
    private $actionRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(ActionRepository $actionRepository, EventRepository $eventRepository,EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->actionRepository = $actionRepository;
        $this->eventRepository = $eventRepository;
    }



    /**
     * @Route("/",name="homepage")
     * @return Response
     */
    public function index()
    {
        $actions = $this->actionRepository->findAll();
        return $this->render('pages/index.html.twig',compact('actions'));
    }

    /**
     * @Route("about", name="team")
     * @return Response
     */
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    /**
     * @Route("action/post/{id}", name="action_post")
     * @param $id
     * @return Response
     */
    public function postAction($id)
    {
        $actions = $this->actionRepository->find($id);
        return $this->render('pages/Action_post.html.twig',compact('actions'));
    }

    /**
     * @Route("event/post/{id}", name="event_post")
     * @param $id
     * @return Response
     */
    public function postEvent($id)
    {
        $events = $this->eventRepository->find($id);
        return $this->render('pages/Event_post.html.twig',compact('events'));
    }
    /**
     * @Route("event", name="event")
     * @return Response
     */
    public function Event(): Response
    {
        $events = $this->eventRepository->findAll();
        return $this->render('pages/Event.html.twig',compact('events'));
    }

    /**
     * @Route("admin/login/association", name="login")
     * @return Response
     */
    public function login(){
        return $this->render('Admin/login.html.twig');
    }

    /**
     * @Route("galery",name="galery")
     * @return Response
     */
    public function images(){
        return $this->render('pages/Galery.html.twig');
    }

}