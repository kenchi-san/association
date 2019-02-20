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
use App\Repository\GaleryRepository;
use App\Repository\MultimediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @var GaleryRepository
     */
    private $galeryRepository;
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var MultimediaRepository
     */
    private $multimediaRepository;

    /**
     * HomeController constructor.
     * @param ActionRepository $actionRepository
     * @param EventRepository $eventRepository
     * @param GaleryRepository $galeryRepository
     * @param EntityManagerInterface $manager
     * @param PaginatorInterface $paginator
     * @param MultimediaRepository $multimediaRepository
     */
    public function __construct(
        ActionRepository $actionRepository,
        EventRepository $eventRepository,
        GaleryRepository $galeryRepository,
        EntityManagerInterface $manager,
        PaginatorInterface $paginator,
        MultimediaRepository $multimediaRepository)
    {
        $this->manager = $manager;
        $this->actionRepository = $actionRepository;
        $this->eventRepository = $eventRepository;
        $this->galeryRepository = $galeryRepository;
        $this->paginator = $paginator;
        $this->multimediaRepository = $multimediaRepository;
    }


    /**
     * @Route("/",name="homepage")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $actions = $this->paginator->paginate(
            $this->actionRepository->OrderByEsc(),
            $request->query->getInt('page', 1),
            6);
        return $this->render('pages/index.html.twig', compact('actions'));
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
        return $this->render('pages/Action_post.html.twig', compact('actions'));
    }

    /**
     * @Route("event/post/{id}", name="event_post")
     * @param $id
     * @return Response
     */
    public function postEvent($id)
    {
        $events = $this->eventRepository->find($id);
        return $this->render('pages/Event_post.html.twig', compact('events'));
    }

    /**
     * @Route("event", name="event")
     * @param Request $request
     * @return Response
     */
    public function event(Request $request): Response
    {
        $events = $this->paginator->paginate(
            $this->eventRepository->OrderByEsc(),
            $request->query->getInt('page', 1),
            10);
        return $this->render('pages/Event.html.twig', compact('events'));
    }


    /**
     * @Route("galery",name="homegalery")
     * @param Request $request
     * @return Response
     */
    public function images(Request $request)
    {
        $galeries = $this->paginator->paginate(
            $this->galeryRepository->OrderByEsc(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('pages/Galery.html.twig', compact('galeries'));
    }

    /**
     * @Route("multimedia", name="homemultimedia")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return mixed
     */
    public function multimediaList(PaginatorInterface $paginator, Request $request){
        $videos = $paginator->paginate(
            $this->multimediaRepository->OrderByEsc(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('pages/multimedia.html.twig', compact('videos'));
    }

    /**
     * @Route("info-parrain", name="homedonation")
     */
    public function parrainOrDonationPage(){

        return $this->render('pages/parrain.html.twig');
    }

    /**
     * @Route("payement/donation",name="donationpage")
     * @return Response
     */
    public function payementPage(){
        return $this->render('pages/payementPage.html.twig');
    }

}