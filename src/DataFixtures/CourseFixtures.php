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
        $courseCate1->setName('Electifs G1');
        
        for($i = 0; $i < mt_rand(5,7); $i++){
            
            $course = new Course();
            $course
                ->setName($faker->city)
                ->setDuration($faker->dateTime)
                ->setDescription($faker->realText($maxNbChars = 40, $indexSize = 2));

            $courseCate1->addCourse($course);    
            $manager->persist($course);
        }

        $courseCate2 = new CourseCategory();
        $courseCate2->setName('Tronc Commun');
        for($i = 0; $i < mt_rand(5,7); $i++){
            
            $course = new Course();
            $course
                ->setName($faker->city)
                ->setDuration($faker->dateTime)
                ->setDescription($faker->realText($maxNbChars = 40, $indexSize = 2));

            $courseCate2->addCourse($course);    
            $manager->persist($course);
        }
        $manager->persist($courseCate1);
        $manager->persist($courseCate2);
        $manager->flush();
    }
}