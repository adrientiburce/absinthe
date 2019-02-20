<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Course;

class ApiController extends Controller
{
    /**
     * @Route("/api/courses", name="api_courses")
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
     * @Route("/api/course/{id}", name="api_course")
     *
     * Needed for client-side navigation after initial page load
     */
    public function apiRecipeAction($id, Request $request)
    {
        $course = $this->getDoctrine()
            ->getRepository(Course::class)
            ->find($id);
        $serializer = $this->get('serializer');

        return new JsonResponse($serializer->normalize($course));
    }
}
