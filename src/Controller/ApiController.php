<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Course;

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
            ->getRepository(Course::class)
            ->findAll();

        return new JsonResponse($serializer->normalize($courses));
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
