<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
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
    public function registration(ObjectManager $manager, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime());
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Utilisateur créé avec succès !');
            return $this->redirectToRoute('app_login');
        }
        // else{
        //     $this->addFlash('danger', 'Un problème est survenu');
        //     return $this->redirectToRoute('register');
        // }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("/mon-compte", name="home_login")
     */
    public function home()
    {
        return $this->render('security/home.html.twig', [

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
