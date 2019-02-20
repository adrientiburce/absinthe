<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @IsGranted("ROLE_USER");
 */
class CourseController extends AbstractController
{
    private $repo;

    public function __construct(CourseRepository $repo)
    {
        $this->repo = $repo;
    }

    public function generateCategory($category)
    {
        $repo = $this->repo;
        $courses = $repo->findWithCategory($category);
        $serializer = $this->get('serializer');
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
            'title' => $category,
            'props' => $serializer->normalize([
                'courses' => $courses])
        ]);
    }

    /**
     * @Route("/cours/tronc-commun", name="course_tronc")
     */
    public function getCourse_tronc()
    {
        return $this->generateCategory('Tronc Commun');
    }

    /**
     * @Route("/cours/electifs/integration", name="course_integration")
     */
    public function getCourse_integration()
    {
        return $this->generateCategory("Electifs d'Integration");
    }

      /**
     * @Route("/cours/electifs/disciplinaires", name="course_disciplinaires")
     */
    public function getCourse_disciplinaires()
    {
        return $this->generateCategory("Electifs Disciplinaires");
    }

    /**
     * @Route("/cours/{id}", name="course_show")
     */
    public function show(Course $course)
    {
        $this->course = $course;
        $serializer = $this->get('serializer');

        return $this->render('course/show.html.twig', [
            'props' => $serializer->normalize(
                ['course' => $course]
            ),
        ]);
    }
}
