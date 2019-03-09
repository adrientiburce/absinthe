<?php

namespace App\Tests\Login;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EasyLogin extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ]);
        $client->request('POST', '/login');
        //print_r($client->getResponse());
        $crawler = $client->followRedirect();
        //$this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/login'));
    }

    // public function testLogin()
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('GET', '/login');
    //     $buttonCrawlerNode = $crawler->selectButton('submit');
    //     $form = $buttonCrawlerNode->form();
    //     $data = array(
    //         'email' => 'admin@demo.fr',
    //         'password' => 'admin');
    //     $client->submit($form,$data);
    // }
}
