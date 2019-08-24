<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ChangePasswordType;
use App\Form\Model\ChangePassword;
use App\Repository\CourseDocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\RouterInterface;

class SecurityController extends AbstractController
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager){
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request) : Response
    {
        if ($this->isGranted('ROLE_USER')) { //Accessible seulement si on n'est pas déjà connecté
            return $this->redirectToRoute('home');
        }

        if ($request->query->get('ticket') == null) { //est géré par le CAS du CLA : donc on redirige vers l'adresse du form de log in
            return new RedirectResponse('http://cla-dev.jeanba.fr/authentification/abc');
        }

        if (($title = $request->query->get('title')) == null) //Si pas de title, on en met un par défaut
            $title = "L'authentification a échoué...";

        if (($contentText = $request->query->get('content-text')) == null) //Si pas de content, on en met un par défaut
            $contentText = "Réessayer";

        return $this->render('security/login.html.twig', [ //on redirige vers la bonne page
            'title' => $title,
            'contentText' => $contentText
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
