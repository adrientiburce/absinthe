<?php

namespace App\Tests\Login;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


class LoginTest extends WebTestCase
{
    private $client = null;
    private $encoder; 

    public function setUp()
    {
        $this->client = static::createClient();
        // $this->encoder = $this
        //     ->getMockBuilder('UserPasswordEncoderInterface')
        //     ->getMock();
    }

    public function testAfterSuccessfulLogin()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/login');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        //$this->assertContains('Cours', $crawler->filter('h1')->text());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $admin = new User();
        $admin->setEmail("admin@demo.fr");
        // $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);

        $token = new PostAuthenticationGuardToken($admin, $firewallName, ['ROLE_ADMIN']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
