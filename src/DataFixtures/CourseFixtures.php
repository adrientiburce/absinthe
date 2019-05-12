<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\CourseCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $courseCate1 = new CourseCategory();
        $courseCate1->setName('Tronc Commun')
            ->setSemester("S5")
            ->setPromotion("G1")
            ->setSlug('tronc-commun');
        for ($i = 0; $i < mt_rand(3, 5); $i++) {
            $course = new Course();
            $course->setName($faker->company)->setDescription($faker->realText($maxNbChars = 80, $indexSize = 2));
            $courseCate1->addCourse($course);
            $manager->persist($course);
        }

        $courseCate2 = new CourseCategory();
        $courseCate2->setName("Electifs d'Integration")
            ->setSemester("S7")
            ->setPromotion("G2")
            ->setSlug('cours-integration');
        for ($i = 0; $i < mt_rand(3, 5); $i++) {
            $course = new Course();
            $course->setName($faker->company)
                ->setDescription($faker->realText($maxNbChars = 80, $indexSize = 2));
            $courseCate2->addCourse($course);
            $manager->persist($course);
        }

        $courseCate3 = new CourseCategory();
        $courseCate3->setName("Electifs Disciplinaires")
            ->setSemester("S6/S8")
            ->setPromotion("G1/G2")
            ->setSlug('cours-disciplinaires');
        for ($i = 0; $i < mt_rand(3, 5); $i++) {
            $course = new Course();
            $course->setName($faker->company)
                ->setDescription($faker->realText($maxNbChars = 80, $indexSize = 2));
            $courseCate3->addCourse($course);
            $manager->persist($course);
        }
        $manager->persist($courseCate1);
        $manager->persist($courseCate2);
        $manager->persist($courseCate3);
        $manager->flush();
    }
}
// SOR  Sociologie des organisations-
// TSI  Traitement du signal
// CMO  Complexité - Modélisation
// AAP  Algorithmique avancée et programmation
// AIN  Analyse pour l'ingénieur
// MMC  Mécanique de milieux continus
// PMO  Physique moderne
