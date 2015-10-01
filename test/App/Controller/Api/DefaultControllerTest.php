<?php

namespace App\Test\Controller\Api;

use App\Test\AppTestCase;

class DefaultControllerTest extends AppTestCase
{
    public function testIndexAction()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/api/');

        $this->assertTrue($client->getResponse()->isOk());

        $this->isInstanceOf(
            '\\Symfony\\Component\\HttpFoundation\\JsonResponse',
            $client->getResponse()
        );

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('data', $content['data']);
    }
}
