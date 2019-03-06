<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Entrez', $crawler->filter('h1')->text());
    }

    public function testRedirectToLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cours-tronc-commun');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testRedirectAfterLogOut()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
}
