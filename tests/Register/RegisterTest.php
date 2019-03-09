<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    public function testSubmitingRegisterForm()
    {
        $client = static::createClient();
        $client->request('POST', '/inscription');
    
        $crawler = $client->submitForm('submit', 
                ['email' => 'test@centrale.centralelille.fr'],
                ['pseudo' => 'pseduo'],
                ['password' => 'testons'],
                ['confirm_password' => 'testons']
            ); 
    }

}
