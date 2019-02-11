<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\CourseCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
   public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $courseCate1 = new CourseCategory();
        $courseCate1->setName('Tronc Commun')
                    ->setSemester("S5");
        for($i = 0; $i < mt_rand(3,5); $i++){
            
            $course = new Course();
            $course->setName($faker->city)
                    ->setDuration($faker->dateTime)
                    ->setDescription($faker->realText($maxNbChars = 40, $indexSize = 2));
            $courseCate1->addCourse($course);    
            $manager->persist($course);
        }

        $courseCate2 = new CourseCategory();
        $courseCate2->setName("Electifs d'Integration")
                    ->setSemester("S7");
        for($i = 0; $i < mt_rand(3,5); $i++){
            $course = new Course();
            $course->setName($faker->city)
                    ->setDuration($faker->dateTime)
                    ->setDescription($faker->realText($maxNbChars = 40, $indexSize = 2));
            $courseCate2->addCourse($course);    
            $manager->persist($course);
        }

        $courseCate3 = new CourseCategory();
        $courseCate3->setName("Electifs Disciplinaires")
                     ->setSemester("S6/S8");
        for($i = 0; $i < mt_rand(3,5); $i++){
            $course = new Course();
            $course->setName($faker->city)
                    ->setDuration($faker->dateTime)
                    ->setDescription($faker->realText($maxNbChars = 40, $indexSize = 2));
            $courseCate3->addCourse($course);    
            $manager->persist($course);
        }
        $manager->persist($courseCate1);
        $manager->persist($courseCate2);
        $manager->flush();
    }
}