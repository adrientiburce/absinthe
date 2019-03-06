<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CourseTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Accueil', $crawler->filter('h1')->text());
    }

    // public function testHomeCourse(){
    //     $client = static::createClient();
    //     $crawler = $client->request('GET', '/cours-tronc-commun');

    //     $this->assertSame(200, $client->getResponse()->getStatusCode());
    //     $this->assertContains('Tronc Commun', $crawler->filter('h1')->text());
    // }
}
