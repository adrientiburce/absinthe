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

class SecurityController extends AbstractController
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager){
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/login/cla", name="app_login_cla")
     */
    public function login_cla(): Response
    {
        //est géré par le CAS du CLA : donc on redirige vers l'adresse du form de log in
        return new RedirectResponse('http://cla.jeanba.fr/authentification/abc');
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request) : Response
    {
        $title  = $request->query->get('title');
        $contentText = $request->query->get('content-text');

        return $this->render('security/login.html.twig', [
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
