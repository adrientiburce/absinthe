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
    private $repo;

    public function __construct(CourseRepository $repo)
    {
        $this->repo = $repo;
    }
    
    /**
     * @Route("/cours", name="course_home")
     */
    public function homeAction(SerializerInterface $serializer)
    {
        $courses = $this->getDoctrine()
            ->getRepository(Course::class)
            ->findAll();

        return $this->render('course/index.html.twig', [
            // We pass an array as props
            'props' => $serializer->serialize(['courses' => $courses], 'json'),
        ]);
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
     * @Route("/course/tronc-commun", name="course_tronc")
     */
    public function getCourse_tronc()
    {
        return $this->generateCategory('Tronc Commun');
    }

    /**
     * @Route("/course/electifs-integration", name="course_integration")
     */
    public function getCourse_integration()
    {
        return $this->generateCategory("Electifs d'Integration");
    }

      /**
     * @Route("/course/electifs-disciplinaires", name="course_disciplinaires")
     */
    public function getCourse_disciplinaires()
    {
        return $this->generateCategory("Electifs Disciplinaires");
    }

    /**
     * @Route("/cours/{id}", name="course_show", requirements={"id"="\d+"})
     */
    public function show($id, Request $request)
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

        if($course->isLikedByUser($user)){
            $favorite = $favoriteRepo->findOneBy([
                'course' => $course,
                'user' => $user,
            ]);

            $manager->remove($favorite);
            $manager->flush();
        }
        else{
            $courseFavorite = new CourseFavorites();
            $courseFavorite->setUser($user)
                            ->setCourse($course);
            $manager->persist($courseFavorite);
            $manager->flush();
        }

    }
}
