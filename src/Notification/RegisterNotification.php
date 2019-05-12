<?php

namespace App\Notification;

use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class RegisterNotification
{

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notifyLogin(User $user, $password)
    {
        $message = (new Swift_Message('Bienvenue sur Absinthe'))
            ->setFrom('noreply@server.com')
            ->setTo($user->getEmail())
            //->setReplyTo($user->getEmail())
            ->setBody($this->renderer->render('emails/register.html.twig', [
                'user' => $user,
                'password' => $password,
            ]), 'text/html');

        $this->mailer->send($message);
    }

    public function notifyResetPass(User $user, $password)
    {
        $message = (new Swift_Message('Absinthe : Récupération du compte'))
            ->setFrom('noreply@server.com')
            ->setTo($user->getEmail())
            //->setReplyTo($user->getEmail())
            ->setBody($this->renderer->render('emails/resetPass.html.twig', [
                'user' => $user,
                'newPass' => $password,
            ]), 'text/html');

        $this->mailer->send($message);
    }
}
