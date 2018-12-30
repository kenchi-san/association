<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 24/12/2018
 * Time: 19:24
 */

namespace App\Controller;


use App\BackManager\ActionManager;
use App\Form\ActionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{

    /**
     * @Route("Add-action", name="Add-action")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ActionManager $actionManager
     * @return Response
     */
    public function FormOfActions( Request $request, EntityManagerInterface $manager, ActionManager $actionManager)
    {
        $action = $actionManager->initAction();
        $form = $this->createForm(ActionType::class,$action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $path = $this->getParameter('kernel.projet dir').'/public/images';
           dump($action);die();

           $name = md5(uniqid()).'.'.$file->guessExtension();

           $file->move($path, $name);

            $image->setName($name);



            $manager->persist($action);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('backend/Form-Add-Action.html.twig', ['form' => $form->createView()]);


    }
}