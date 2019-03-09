<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnonymousUrlsTest extends WebTestCase
{
    /**
     * @dataProvider getUrls
     */
    public function testUrlsAnonymousUserCanAcces($url, $value)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains($value, $crawler->filter('h1')->text());
    }

    public function getUrls()
    {
        return array(
            ['/', 'Accueil'],
            ['/login', 'Entrez'],
            ['/inscription', 'Utiliser']
        );
    }
}
