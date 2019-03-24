<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\CourseCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/cours", name="api_courses")
     *
     * Needed for client-side navigation after initial page load
     */
    public function apiCoursesAction(Request $request)
    {
        $serializer = $this->get('serializer');

        $courses = $this->getDoctrine()
            ->getRepository(CourseCategory::class)
            ->findAll();

            return new JsonResponse([
                'courses'=>$serializer->normalize($courses),
            ]);
    }

    /**
     * @Route("/api/cours/{id}", name="api_course", requirements={"id"="\d+"})
     *
     * Needed for client-side navigation after initial page load
     */
    public function apiCourseAction($id, Request $request)
    {
        $serializer = $this->get('serializer');
        $course = $this->getDoctrine()
            ->getRepository(Course::class)
            ->find($id);
        $isLikedByUser = $course->isLikedByUser($this->getUser());
        
        return new JsonResponse([
            'course'=>$serializer->normalize($course),
            'isLikedByUser' => $isLikedByUser
        ]);
    }
}
