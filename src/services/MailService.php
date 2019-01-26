<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 11/01/2019
 * Time: 11:18
 */

namespace App\services;


use Twig\Environment;

class MailService
{

    private $swahilisaMailer;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * MailService constructor.
     * @param $swahilisaMailer
     * @param Environment $environment
     * @param \Swift_Mailer $mailer
     */
    public function __construct(
        $swahilisaMailer,
        Environment $environment,
        \Swift_Mailer $mailer)
    {
        $this->swahilisaMailer = $swahilisaMailer;
        $this->environment = $environment;
        $this->mailer = $mailer;
    }

    public function index($name, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Nouvelle évènement chez swahilisa'))
            ->setFrom($this->swahilisaMailer)
            ->setTo('charon.hugo@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            );

        $mailer->send($message);

        return $this->render();
    }
}