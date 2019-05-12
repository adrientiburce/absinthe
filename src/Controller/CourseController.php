<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Entity\CourseCategory;
use App\Entity\CourseFavorites;
use App\Repository\CourseRepository;
use App\Repository\CourseCategoryRepository;
use App\Repository\CourseFavoritesRepository;
use DateTime;
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

    public function __construct(CourseRepository $courseRepository, CourseCategoryRepository $categoryRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/categorie/{slug}", name="course_category", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function showCoursesFromOneCategory(CourseCategory $category, string $slug, Request $request)
    {

        if ($category->getSlug() !== $slug) {
            return $this->redirectToRoute('course_category', [
                'slug' => $category->getSlug()
            ], 301);
        }
        $serializer = $this->get('serializer');

        $courseRepository = $this->courseRepository;
        $courses = $courseRepository->findCoursesWithSlug($slug);
        $categoryRepository = $this->categoryRepository;
        $category = $categoryRepository->findBy(array('slug' => $slug));


        return $this->render('course/index.html.twig', [
            // We pass an array as props
            'props' => $serializer->serialize([
                'courses' => $courses,
                'category' => $category
            ], 'json'),
        ]);
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

    /**
     * @Route("/creer-cours", name="course_create")
     */
    public function createCourse(Request $request, ObjectManager $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $course = new Course();

        $entityManager->flush();
        $form = $this->createForm(CourseType::class, $course)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Cours ajouté avec succès');
            $course->setCreatedAt(new DateTime('now'));
            $entityManager->persist($course);
            $manager->flush();
            return $this->redirectToRoute('course_create');
        }
        return $this->render('course/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
