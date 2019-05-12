<?php

namespace App\Service;

use App\Entity\CourseCategory;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryGenerator
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getSlug()
    {
        $category = $this->manager
            ->getRepository(CourseCategory::class)
            ->findAll();

        return $category;
    }
}
