<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CourseController extends AbstractController
{
    private $repo; 

    public function __construct(CourseRepository $repo){
        $this->repo = $repo;
    }

    /**
     * @Route("/cours", name="course_index")
     */
    public function index()
    {
        $repo = $this->repo;
        $courses = $repo->findAll();
        return $this->render('course/index.html.twig', [
            'courses' => $courses
        ]);
    }

    /**
     * @Route("/cours/{id}", name="course_show")
     */
    public function show(Course $course)
    {
        $this->course = $course;
        
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }
}
