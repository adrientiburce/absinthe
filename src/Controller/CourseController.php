<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\CourseFavorites;
use App\Repository\CourseRepository;
use App\Repository\CourseFavoritesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @IsGranted("ROLE_USER");
 */
class CourseController extends AbstractController
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    
    /**
     * fetch courses from repository with category 
     */
    public function generateCoursesCategory(string $category)
    {
        $courseRepository = $this->courseRepository;
        $courses = $courseRepository->findCourseWithCategory($category);
        $serializer = $this->get('serializer');
        return $this->render('course/index.html.twig', [
            // We pass an array as props
            'props' => $serializer->serialize(['courses' => $courses], 'json'),
        ]);
    }

    /**
     * @Route("/cours-tronc-commun", name="course_tronc")
     */
    public function getCourse_tronc()
    {
        return $this->generateCoursesCategory('Tronc Commun');
    }

    /**
     * @Route("/cours-integration", name="course_integration")
     */
    public function getCourse_integration()
    {
        return $this->generateCoursesCategory("Electifs d'Integration");
    }

    /**
     * @Route("/cours-disciplinaires", name="course_disciplinaires")
     */
    public function getCourse_disciplinaires()
    {
        return $this->generateCoursesCategory("Electifs Disciplinaires");
    }

    /**
     * @Route("/cours/{id}", name="course_show", requirements={"id"="\d+"})
     */
    public function showCourse($id, Request $request)
    {
        $serializer = $this->get('serializer');
        $course = $this->getDoctrine()
            ->getRepository(Course::class)
            ->find($id);
        $user = $this->getUser();
        $isLikedByUser = $course->isLikedByUser($user);

        return $this->render('course/show.html.twig', [
            // We pass an array as props
            'props' => $serializer->serialize($course, 'json'),
            'course' => $course
        ]);
    }

    /**
     * @Route("/cours/favorite/{id}", name="course_favorites", requirements={"id"="\d+"})
     */
    public function favorites(Course $course, CourseFavoritesRepository $favoriteRepo, ObjectManager $manager)
    {
        $user = $this->getUser();

        if ($course->isLikedByUser($user)) {
            $favorite = $favoriteRepo->findOneBy([
                'course' => $course,
                'user' => $user,
            ]);

            $manager->remove($favorite);
            $manager->flush();
        } else {
            $courseFavorite = new CourseFavorites();
            $courseFavorite->setUser($user)
                            ->setCourse($course);
            $manager->persist($courseFavorite);
            $manager->flush();
        }
    }

    /**
     * @Route("/cours-favoris", name="my_courses")
     */
    public function showFavoriteCourse(SerializerInterface $serializer)
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $courses = $this->getDoctrine()
            ->getRepository(Course::class)
            ->findCoursesLikedByUser($userId);

        $serializer = $this->get('serializer');
        return $this->render('course/myCourses.html.twig', [
            // We pass an array as props
            'props' => $serializer->serialize(['courses' => $courses], 'json'),
        ]);
    }
}
