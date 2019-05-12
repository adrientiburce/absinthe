<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ResetPasswordType;
use App\Form\Model\ResetPassword;
use App\Notification\RegisterNotification;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $objectManager;
    private $passGenerator;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->passGenerator = new ComputerPasswordGenerator();

        $this->passGenerator
            ->setOptionValue(ComputerPasswordGenerator::OPTION_UPPER_CASE, true)
            ->setOptionValue(ComputerPasswordGenerator::OPTION_LOWER_CASE, true)
            ->setOptionValue(ComputerPasswordGenerator::OPTION_NUMBERS, true)
            ->setOptionValue(ComputerPasswordGenerator::OPTION_SYMBOLS, true)
            ->setLength(8);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function registration(ObjectManager $manager, Request $request, UserPasswordEncoderInterface $encoder, RegisterNotification $notification)
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime("now", new \DateTimeZone('Europe/Paris')));

            $passwordGenerated = $this->passGenerator->generatePassword();
            $user->setPassword($encoder->encodePassword($user, $passwordGenerated));

            $manager->persist($user);
            $manager->flush();

            $notification->notifyLogin($user, $passwordGenerated);

            $this->addFlash(
                'success',
                'Utilisateur créé, consultez vos mails pour vous connecter (vérifiez les indésirables) '
            );
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/login-recuperation", name="reset_pass")
     */
    public function resetPassword(
        ObjectManager $manager,
        Request $request,
        UserPasswordEncoderInterface $encoder,
        RegisterNotification $notification
    ) {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $userEmail = new ResetPassword();
        $form = $this->createForm(ResetPasswordType::class, $userEmail)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $isUser = $repository->findOneBy(['email' => $userEmail->getEmail()]);
            if ($isUser) {
                $newPasswordGenerated = $this->passGenerator->generatePassword();
                $isUser->setPassword($encoder->encodePassword($isUser, $newPasswordGenerated));
                $manager->flush();
                $notification->notifyResetPass($isUser, $newPasswordGenerated);

                $this->addFlash(
                    'success',
                    'Nouveau mot de passe envoyé, consultez vos mails (vérifiez les indésirables)'
                );
            } else {
                $this->addFlash('warning', "Ce compte n'existe pas");
            }

            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/reset.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }
}
