<?php

namespace App\Tests\Login;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    private $client;

    private $crawler;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/login');
        $this->client->followRedirects();
        $form = $this->crawler->selectButton('Connexion')->form();
        $form['email'] = 'admin@demo.fr';
        $form['password'] = 'admin';
        $this->crawler = $this->client->submit($form);
    }

    /** 
     * @dataProvider getCourse
     */
    public function testApiRouteRendersValidJson($route, $key)
    {
        $this->client->request('GET',$route );  // all courses 
        $response = $this->client->getResponse();
        $content = json_decode($response->getContent(), true);
        //print_r($content);
        $this->assertArrayHasKey($key, $content);    
    }

    public function getCourse()
    {
        return array(
            ['/api/cours', 0],
            ['/api/cours/1', 'course']
        );
    }

    public function tearDown()
    {
        $this->client = null;
        $this->crawler = null;
    }
}
