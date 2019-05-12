<?php

namespace App\Controller;

use App\Entity\CourseDocument;
use App\Form\DocumentFormType;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentController extends AbstractController
{

    /**
     * @IsGranted("ROLE_USER");
     * @Route("/upload", name="document_upload")
     */
    public function index(Request $request, ObjectManager $manager)
    {
        $courseDocument = new CourseDocument();

        $form = $this->createForm(DocumentFormType::class, $courseDocument);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseDocument->setUpdatedAt(new DateTime());
            $courseDocument->setAuthor($this->getUser());

            $manager->persist($courseDocument);
            $manager->flush();

            $this->addFlash('success', 'Document uploadé avec succès !');
            return $this->redirectToRoute('document_upload');
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('danger', 'une erreur est survenu');
        }
        return $this->render('document/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
