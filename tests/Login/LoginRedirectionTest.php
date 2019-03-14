<?php

namespace App\Tests\Login;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginRedirectionTest extends WebTestCase
{
    public function testShouldShowLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Entrez vos identifiants', $crawler->filter('h1')->text());
    }

    public function testShouldRedirectToLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Connexion')->link();
        $crawler = $client->click($link);
        $this->assertContains('Entrez vos identifiants', $crawler->filter('h1')->text());
    }

    public function testShouldRedirectAfterLogOut()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
}
