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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{

    /**
     * @param Request $request
     * @param Action $action
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route(path="action/{id}/edit", name="action_edit")
     */
    public function editAction(Request $request,Action $action, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ActionType::class,$action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $path = $this->getParameter('kernel.project_dir').'/public/images';

            $file = $action->getImage()->getFile();

            $name = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($path, $name);

            $action->getImage()->setName($name);



            $manager->persist($action);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('backend/Form-Add-Action.html.twig', ['form' => $form->createView()]);


    }

    /**
     * @Route("add-action", name="Add-action")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ActionManager $actionManager
     * @return Response
     */
    public function addAction( Request $request, EntityManagerInterface $manager, ActionManager $actionManager)
    {
        $action = $actionManager->initAction();
        $form = $this->createForm(ActionType::class,$action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            dump($action->getImage()->getFile());
            $path = $this->getParameter('kernel.project_dir').'/public/images';

            $file = $action->getImage()->getFile();

           $name = md5(uniqid()).'.'.$file->guessExtension();

           $file->move($path, $name);

            $action->getImage()->setName($name);



            $manager->persist($action);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('backend/Form-Add-Action.html.twig', ['form' => $form->createView()]);


    }



    /**
     * @Route("Add-event", name="Add-event")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ActionManager $actionManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function FormOfEvent(Request $request, EntityManagerInterface $manager, ActionManager $actionManager)
    {
        $action = $actionManager->initAction();
        $form = $this->createForm(ActionType::class,$action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($action);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('backend/Form-Add-Event.html.twig', ['form' => $form->createView()]);


    }
}