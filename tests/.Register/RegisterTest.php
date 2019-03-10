<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    public function testSubmitRegisterForm()
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        $client->followRedirects();
        $crawler = $client->submitForm("S'inscrire",
                ['user[email]' => 'testons@centrale.centralelille.fr',
                "user[pseudo]" => 'pseudo',
                "user[password]" => 'testons',
                "user[confirm_password]" => 'testons']
            );
        // $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        //echo $client->getResponse();
    }

    public function tearDown()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['email' => 'testons@centrale.centralelille.fr']);

    }
}
