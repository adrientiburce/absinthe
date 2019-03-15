<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions")
     */
    public function showMentionsLegaes()
    {
        return $this->render('home/mentions.html.twig', [
        ]);
    }
}
