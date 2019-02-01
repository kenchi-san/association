<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 26/01/2019
 * Time: 02:20
 */

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactType;
use App\services\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MailingController extends AbstractController
{
    /**
     * @var MailService
     */
    private $mail;
    /**
     * @var MailService
     */
    private $mailService;

    /**
     * MailingController constructor.
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {

        $this->mailService = $mailService;
    }

    /**
     * @Route("/contact-us",name="contactUs")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactUs(Request $request, EntityManagerInterface $manager){

        $mail = new Contact();
        $form = $this->createForm(ContactType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($mail);
            $manager->flush();
            $this->mailService->sendTheQuestionByMail($mail);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('pages/ContactUs.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/Mailing/forget-password",name="forgotPassword")
     */
    public function passwordForgot() {
        $this->render('');
    }
}