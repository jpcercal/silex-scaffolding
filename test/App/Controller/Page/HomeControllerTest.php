<?php

namespace App\Test\Controller\Page;

use App\Test\AppTestCase;

class HomeControllerTest extends AppTestCase
{
    public function testIndexAction()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());

        $this->assertEquals('Hello', $crawler->filter('h1')->first()->text());
    }
}
