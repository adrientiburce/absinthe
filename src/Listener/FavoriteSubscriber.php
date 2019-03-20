<?php
namespace App\Listener;

use App\Entity\CourseFavorites;
use App\Entity\Course;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Common\Persistence\ObjectManager;


class FavoriteSubscriber implements EventSubscriber
{
    
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

    }

    public function getSubscribedEvents()
    {
        return [
            'postUpdate',
        ];
    }
    
    public function postUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Course){
            return;
        }
        // elseif($entity->getCourseCategory() == null){
        else{
            // we remove this course from all users favorites courses
            $manager = $this->manager;
            $courseId = $entity->getId();
            $entityManager = $args->getObjectManager();
            $coursesLiked = $manager->getRepository(CourseFavorites::class)
                                    ->findAll();
            // print_r($coursesLiked);
            foreach($coursesLiked as $course){
                $manager->remove($course);
                
            }
            $manager->flush();
        };
    }

    // public function preRemove(LifecycleEventArgs $args)
    // {
    //     $entity = $args->getEntity();
    //     if(!$entity instanceof Course){
    //         return;
    //     }
    //     if($entity->getCourseCategory() == null){
    //         // we remove this course from all users favorites courses
    //         $courseId = $entity->getId();
    //         $coursesLiked = $manager->getRepository(CourseFavorites::class)
    //                                 ->findBy(["id" => $courseId]);
    //         foreach($course as $coursesLiked){
    //             $manager->remove($course);
    //             $manager->flush();
    //         }

    //     };
    // }
} 