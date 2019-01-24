<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 24/12/2018
 * Time: 19:24
 */

namespace App\Controller;


use App\BackManager\ActionManager;

use App\Entity\Action;
use App\Form\ActionType;
use App\Repository\ActionRepository;
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
class AdminActionController extends AbstractController
{
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;


    /**
     * AdminActionController constructor.
     * @param ActionRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct( EntityManagerInterface $manager, ActionRepository $repository)
    {

        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/",name="admin")
     * @return Response
     */
    public function index()
    {
        return $this->render('Admin/index.html.twig');
    }

    /**
     * @Route("/actions/list",name="admin_actions_list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function actionsList(PaginatorInterface $paginator, Request $request){
        $actions = $paginator->paginate(
           $this->repository->OrderByEsc(),
            $request->query->getInt('page', 1),
            5);
        return $this->render('Admin/actions_list.html.twig', compact('actions'));
    }

    /**
     * @Route("/action/delete/{id}", name="admin_action_delete", methods="DELETE")
     * @param Action $action
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function actionDelete(Action $action)
    {

        $this->manager->remove($action);
        $this->manager->flush();
        return $this->redirectToRoute('admin');

    }

    /**
     * @param Request $request
     * @param Action $action
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/action/{id}/edit", name="admin_action_edit", methods="GET|POST")
     *
     */
    public function actionEdit(Request $request, Action $action)
    {
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            return $this->redirectToRoute('admin_actions_list');
        }

        return $this->render('Admin/action_edit.html.twig', [
            'actions' => $action,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/action/add", name="admin_action_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ActionManager $actionManager
     * @return Response
     */
    public function actionAdd(Request $request, EntityManagerInterface $manager, ActionManager $actionManager)
    {
        $action = $actionManager->initAction();
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($action);
            $manager->flush();

            return $this->redirectToRoute('admin_actions_list');
        }

        return $this->render('Admin/action_add.html.twig', ['form' => $form->createView()]);


    }


}