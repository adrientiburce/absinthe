<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ChangePasswordType;
use App\Form\Model\ChangePassword;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager){
        $this->objectManager = $objectManager;
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
     * @Route("/mon-compte", name="home_profile")
     * @IsGranted("ROLE_USER");
     */
    public function home_profile(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $userPassword = new ChangePassword();
        $objectManager = $this->objectManager;
        
        $formPassword=$this->createForm(ChangePasswordType::class, $userPassword);
        $formPassword->handleRequest($request);
        $user = $this->getUser();
        if($formPassword->isSubmitted() && $formPassword->isValid()){
            $this->addFlash('success', 'Mot de Passe mis à jour avec succès');
            $hash = $encoder->encodePassword(
                    $user,
                    $userPassword->getPassword());
            $user->setPassword($hash);
            $objectManager->flush();
            return $this->redirectToRoute('home_profile');
        }
        else if($formPassword->isSubmitted()){
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('home_profile');
        }


        $formProfile = $this->createForm(UserType::class, $user);
        $formProfile->remove('email');
        $formProfile->remove('password');
        $formProfile->remove('confirm_password');

        $formProfile->handleRequest($request);
        if($formProfile->isSubmitted() && $formProfile->isValid()){
            $this->addFlash('success', 'Profil mis à jour avec succès');
            $user->setPseudo($user->getPseudo());
            $objectManager->flush();
            return $this->redirectToRoute('home');
        }
        else if($formProfile->isSubmitted()){
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('home_profile');
        }
        return $this->render('security/home.html.twig',[
            'formPassword' => $formPassword->createView(),
            'formProfile' => $formProfile->createView(),
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
