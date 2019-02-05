<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 11/01/2019
 * Time: 11:18
 */

namespace App\services;


use App\Entity\Contact;
use App\Entity\User;
use Twig\Environment;

class MailService
{

    private $swahilisaMailer;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * MailService constructor.
     * @param $swahilisaMailer
     * @param Environment $twig
     * @param \Swift_Mailer $mailer
     */
    public function __construct(
        $swahilisaMailer,
        Environment $twig,
        \Swift_Mailer $mailer)
    {
        $this->swahilisaMailer = $swahilisaMailer;
        $this->environment = $twig;
        $this->mailer = $mailer;
    }


    /**
     * @param Contact $contact
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendTheQuestionByMail(Contact $contact)
    {
        $mailer = new \Swift_Message('Nouvelle question');
        $mailer->setFrom([$contact->getMail() => $contact->getName()]);
        $mailer->setTo($this->swahilisaMailer);
        //$urlLogo = $mail->embed(\Swift_Image::fromPath('images_static/LogoFB.jpg'));

        $mailer->setBody(
            $this->environment->render('Mail/ContactGuest.html.twig', ['GuestQuestion' => $contact]), 'text/html'
        );

        $this->mailer->send($mailer);
    }



    public function sendTheLinkForResetPassword(User $user){
        $mailer = new \Swift_Message('Réinitialisation du mot de passe');
        $mailer->setFrom($this->swahilisaMailer);
        $mailer->setTo($user->getMail());
        $mailer->setBody(
            $this->environment->render('security/ResetPassword.html.twig', ['resetPassword' => $user]), 'text/html'
        );

        $this->mailer->send($mailer);

    }
}