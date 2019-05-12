<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\CourseDocument;
use App\Form\ChangePasswordType;
use App\Form\Model\ChangePassword;
use App\Repository\CourseDocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @IsGranted("ROLE_USER");
 */
class ProfileController extends AbstractController
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param CourseDocumentRepository $documentRepository
     * @return RedirectResponse|Response
     * @Route("/mon-compte", name="home_profile")
     */
    public function homeProfile(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        CourseDocumentRepository $documentRepository
    ) {
        $user = $this->getUser();
        $objectManager = $this->objectManager;
        // handle Form for P A S S W O R D
        // $userPassword = new ChangePassword();
        // $formPassword=$this->createForm(ChangePasswordType::class, $userPassword)
        //                     ->handleRequest($request);

        // $isPassModalOpen = false;
        // if($formPassword->isSubmitted() && !$formPassword->isValid()){
        //     $isPassModalOpen = true;
        // }
        // if($formPassword->isSubmitted() && $formPassword->isValid()){
        //     $this->addFlash('success', 'Mot de Passe mis à jour avec succès');
        //     $hash = $encoder->encodePassword(
        //             $user,
        //             $userPassword->getPassword());
        //     $user->setPassword($hash);
        //     $objectManager->flush();
        //     return $this->redirectToRoute('home_profile');
        // }

        // handle Form for P S E U D O
        $formPseudo = $this->createForm(UserType::class, $user)
            ->remove('email')
            ->handleRequest($request);
        $isPseudoModalOpen = false;

        if ($formPseudo->isSubmitted() && !$formPseudo->isValid()) {
            dump($formPseudo->getData()->getPseudo());
            dump($user->getPseudo());
            $user->setPseudo($formPseudo->getData()->getPseudo());
            $isPseudoModalOpen = true;
        }
        if ($formPseudo->isSubmitted() && $formPseudo->isValid()) {
            $this->addFlash('success', 'Profil mis à jour avec succès');
            $objectManager->flush();
            return $this->redirectToRoute('home_profile');
        }
        dump($formPseudo);
        $documents = $documentRepository->findDocumentByUser($user);
        return $this->render('profile/index.html.twig', [
            // 'formPassword' => $formPassword->createView(),
            // 'isPassModalOpen' => $isPassModalOpen,
            'documents' => $documents,
            'formPseudo' => $formPseudo->createView(),
            'isPseudoModalOpen' => $isPseudoModalOpen,
            'user' => $user
        ]);
    }

    /**
     * @Route("/document/{id}", name="document_delete", methods="DELETE")
     */
    public function deleteDocuments(CourseDocument $document, ObjectManager $manager, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->get('_token'))) {
            $manager->remove($document);
            $manager->flush();
            $this->addFlash('success', 'Document supprimé avec succès');
        }
        return $this->redirectToRoute('home_profile');
    }
}
