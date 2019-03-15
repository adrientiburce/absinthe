<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UrlsTest extends WebTestCase
{
    /**
     * @dataProvider getPublicUrls
     */
    public function testUrlsAnonymousUserCanAcces($url, $value)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains($value, $crawler->filter('h1')->text());
    }

    public function getPublicUrls()
    {
         return array(
            ['/', 'Accueil'],
            ['/login', 'Entrez'],
            ['/inscription', 'Utiliser']
         );
    }

    /**
     * @dataProvider getPrivateUrls
     */
    public function testShouldRedirect($url)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isRedirect('/login'));
    }

    public function getPrivateUrls()
    {
        return array(
            ['/admin'],
            ['/cours-tronc-commun'],
            ['/cours-disciplinaires'],
            ['/cours-integration'],
            ['/mon-compte'],
        );
    }
    
}
