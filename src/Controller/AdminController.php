<?php

namespace App\Controller;

use App\Entity\CourseFavorites;
use App\Entity\Course;
use Doctrine\Common\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

class AdminController extends EasyAdminController
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * check if the updated course has been liked and remove from all favorites courses
     * for all users
     */
    public function updateEntity($entity)
    {
        $manager = $this->manager;
        if (!$entity instanceof Course) {
            parent::updateEntity($entity);
            return;
        } elseif ($entity->getCourseCategory() == null) {
            $courseId = $entity->getId();
            $coursesLiked = $manager->getRepository(CourseFavorites::class)
                ->findBy(["course" => $courseId]);
            foreach ($coursesLiked as $course) {
                $manager->remove($course);
            }
            $manager->flush();
        }
        parent::updateEntity($entity);
    }
}
