<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 11/01/2019
 * Time: 11:18
 */

namespace App\services;


use App\Entity\Contact;
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

    public function sendTheQuestionByMail(Contact $contact)
    {
        $mail = (new \Swift_Message('Nouvelle évènement chez swahilisa'));
            $mail->setFrom($contact->getMail());
            $mail->setTo($this->swahilisaMailer);
            $mail->setBody(
                $this->twig->render(
                    'Mail/ContactGuest.html.twig',
                    ['GuestQuestion' => $contact]
                ),
                'text/html'
            );

        $this->mailer->send($mail);
    }
}