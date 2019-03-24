<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class RegisterTest extends WebTestCase
{
    // public function testSubmitRegisterForm()
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/inscription');
    //     $client->followRedirects();
    //     $crawler = $client->submitForm("S'inscrire",
    //             ['user[email]' => 'admin@centrale.centralelille.fr',
    //             'user[password]' => 'testons',
    //             'user[confirm_password]' => 'testons']
    //         );
    //     $this->assertSame(1, $crawler->filter('div.alert-success')->count());
    // }
}
