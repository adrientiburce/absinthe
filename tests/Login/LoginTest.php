<?php

namespace App\Tests\Login;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Form\Type\TestedType;
use App\Model\TestObject;
use Symfony\Component\Form\Test\TypeTestCase;



class LoginTest extends WebTestCase
{
    private $client;

    private $crawler;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/login');
        $this->client->followRedirects();
    }

    public function testShouldLogUserAndRedirectToHomePage()
    {
        $form = $this->crawler->selectButton('Connexion')->form();
        $form['email'] = 'admin@demo.fr';
        $form['password'] = 'admin';
        $crawler = $this->client->submit($form);

        $this->assertContains('Accueil', $crawler->filter('h1')->text());
        $this->assertSame(1, $crawler->filter('#nav__logout')->count());
    }

    public function testWithFalseCredentials()
    {
        $form = $this->crawler->selectButton('Connexion')->form();
        $form['email'] = 'admin@demo.fr';
        $form['password'] = 'a_wrong_password';
        $crawler = $this->client->submit($form);

        $this->assertContains('Entrez', $crawler->filter('h1')->text());
        $this->assertSame(1, $crawler->filter('div.alert.alert-danger')->count());
    }
    
}
