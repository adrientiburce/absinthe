<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\CourseDocument;
use App\Repository\CourseDocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @IsGranted("ROLE_USER");
 */
class ProfileController extends AbstractController
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager){
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/mon-compte", name="home_profile")
     */
    public function home_profile(Request $request, CourseDocumentRepository $documentRepository)
    {
        $objectManager = $this->objectManager;
        
        $user = $this->getUser();
        $isModalOpen = false;

        $formProfile = $this->createForm(UserType::class, $user)
                            ->handleRequest($request);
        if($formProfile->isSubmitted()){
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('home_profile');
        }
        if($formProfile->isSubmitted() && $formProfile->isValid()){
            $this->addFlash('success', 'Profil mis à jour avec succès');
            $objectManager->flush();
            return $this->redirectToRoute('home');
        }
        // else if($formProfile->isSubmitted()){
        //     $this->addFlash('danger', 'Un problème est survenu');
        //     return $this->redirectToRoute('home_profile');
        // }
        
        $documents = $documentRepository->findDocumentByUser($user);
        return $this->render('profile/index.html.twig',[
            'formProfile' => $formProfile->createView(),
            'documents' => $documents,
            'isModalOpen' => $isModalOpen,
        ]);
    }

    /**
     * @Route("/document/{id}", name="document_delete", methods="DELETE")
     */
    public function deleteDocuments(CourseDocument $document, ObjectManager $manager, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $document->getId(), $request->get('_token'))){
            $manager->remove($document);
            $manager->flush();
            $this->addFlash('success', 'Document supprimé avec succès');
        }
        return $this->redirectToRoute('home_profile');
    }

}