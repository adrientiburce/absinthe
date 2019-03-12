<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class RegisterTest extends WebTestCase
{
    public function setUp()
    {
        self::run('doctrine:database:create --env=test', $output);
        self::run('doctrine:schema:update --env=test', $output);
        parent::setUp();
    }

    public function testSubmitRegisterForm()
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        $client->followRedirects();
        $crawler = $client->submitForm("S'inscrire",
                ['user[email]' => 'gre@centrale.centralelille.fr',
                'user[password]' => 'testons',
                'user[confirm_password]' => 'testons']
            );
        //$crawler = $client->followRedirect();
        echo $client->getResponse();
        $this->assertSame(1, $crawler->filter('div.alert-success')->count());

    }

    protected function tearDown()
    {
        self::run('doctrine:database:drop --force --env=test');

        parent::tearDown();
    }
}
