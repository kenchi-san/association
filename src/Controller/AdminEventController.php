<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 08/01/2019
 * Time: 00:02
 */

namespace App\Controller;

use App\BackManager\EventManager;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminActionController
 * @package App\Controller
 *
 * @Route(path="/admin")
 */
class AdminEventController extends AbstractController
{
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * AdminActionController constructor.
     * @param EventRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(EventRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;

        $this->manager = $manager;
    }


    /**
     * @Route("/events/list",name="admin_events_list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function eventsList(PaginatorInterface $paginator, Request $request)
    {
        $events = $paginator->paginate(
            $this->repository->OrderByEsc(),
            $request->query->getInt('page', 1),
            5);
        return $this->render('Admin/events_list.html.twig', compact('events'));

    }

    /**
     * @Route("/event/delete/{id}", name="admin_event_delete", methods="DELETE")
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function eventDelete(Event $event)
    {

        $this->manager->remove($event);
        $this->manager->flush();
        return $this->redirectToRoute('admin');

    }

    /**
     * @param Request $request
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/event/{id}/edit", name="admin_event_edit", methods="GET|POST")
     */
    public function eventEdit(Request $request, Event $event)
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->flush();

            return $this->redirectToRoute('admin_events_list');
        }

        return $this->render('Admin/event_edit.html.twig', [
            'events' => $event,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/event/add", name="admin_event_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param EventManager $eventManager
     * @return Response
     */
    public function eventAdd(Request $request, EntityManagerInterface $manager, EventManager $eventManager)
    {
        $event = $eventManager->initEvent();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($event);
            $manager->flush();

            return $this->redirectToRoute('admin_events_list');
        }

        return $this->render('Admin/event_add.html.twig', ['form' => $form->createView()]);


    }


}