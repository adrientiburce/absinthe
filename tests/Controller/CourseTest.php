<?php

namespace App\Tests\Login;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Form\Type\TestedType;
use App\Model\TestObject;
use Symfony\Component\Form\Test\TypeTestCase;

class CourseTest extends WebTestCase
{
    private $client;
    private $crawler;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/login');
        $this->client->followRedirects();
    }

    /**
     * @dataProvider getCourses
     */
    public function testShouldShowCourses($link_name, $result)
    {
        $form = $this->crawler->selectButton('Connexion')->form();
        $form['email'] = 'admin@centrale.centralelille.fr';
        $form['password'] = 'testons';
        $crawler = $this->client->submit($form);
        $link = $crawler->selectLink($link_name)->link();
        $crawler = $this->client->click($link);
        $this->assertContains($result, $crawler->filter('h1')->text());
    }

    public function getCourses()
    {
        return array(
            ['Tronc Commun', 'Cours :Tronc Commun'],
            ['Electifs Disciplinaires', "Cours :Electifs Disciplinaires"],
            // ["Electifs d'Intégration", "Cours :Electifs d'Integration"],
        );
    }

    public function tearDown()
    {
        $this->client = null;
        $this->crawler = null;
    }
}
