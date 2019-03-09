<?php

namespace App\Tests\Login;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{

    public function testApiRouteShowAllCourses()
    {
        $client = static::createClient();
        $client->request('GET', '/api/cours/1');  // all courses 
        //print_r($client);
        //$this->assertSame(200, $client->getResponse()->StatusCode());   
    }
}
