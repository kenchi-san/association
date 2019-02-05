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
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use App\services\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MailingController extends AbstractController
{


    /**
     * @Route("/contact-us",name="contactUs")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param MailService $mailService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contactUs(Request $request, EntityManagerInterface $manager, MailService $mailService)
    {

        $mail = new Contact();
        $form = $this->createForm(ContactType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($mail);
            $mailService->sendTheQuestionByMail($mail);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('pages/ContactUs.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/reset-password",name="resetPassword")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $manager
     * @param MailService $mailService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function passwordForgotten(Request $request, UserRepository $userRepository, EntityManagerInterface $manager, MailService $mailService)
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->findOneBy(['mail' => $data['mail']]);

            if($user){
                // faire qqch
                $user->setToken(md5(random_bytes(10)));
                $manager->persist($user);
                $manager->flush();
                $mailService->sendTheLinkForResetPassword($user);


                $this->addFlash('success', 'Le mail de réinitiliastion du mdp vient d\'être envoyé');

            }else{
                $this->addFlash('danger', 'Error');
            }


        }
        return $this->render('Admin/ForgottenPage.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new-password/{token}",name="newPassword")
     * @param $password
     */
public function newPassWordForm($token){

return $this->render('security/SettupNewPassWord.html.twig',compact('result'));

}
}