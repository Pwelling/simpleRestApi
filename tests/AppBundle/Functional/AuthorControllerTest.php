<?php

namespace Test\AppBundle\Functional;

use Tests\AppBundle\BaseFixtureTest;

class AuthorControllerTest extends BaseFixtureTest
{
    /**
     * @covers \AppBundle\Controller\AuthorController::getAction
     */
    public function testGetAction()
    {
        $client = $this->makeClient();
        $client->request('GET', '/authors/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $expected =
            '{"id":1,"name":"Stephen King","books":[{"id":1,"title":"It","highlighted":false,"publisher":'
            . '{"id":1,"name":"Harlekijn","books":[]}}]}';
        $this->assertSame($expected, $client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\AuthorController::getAction
     */
    public function testGetActionNotFound()
    {
        $client = $this->makeClient();
        $client->request('GET', '/authors/20');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame('["Author not found"]', $client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\AuthorController::listAction
     */
    public function testListAction()
    {
        $client = $this->makeClient();
        $client->request('GET', '/authors/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $expected =
            '[{"id":1,"name":"Stephen King","books":[{"id":1,"title":"It","highlighted":false,"publisher":'
            .   '{"id":1,"name":"Harlekijn","books":[]}}]},{"id":2,"name":"Jane Wolkers","books":['
            .   '{"id":3,"title":"Terug naar Oegstgeest","highlighted":false,"publisher":'
            .   '{"id":3,"name":"Elastique","books":[]}}]},{"id":3,"name":"Sybren Polet","books":[]},'
            .   '{"id":4,"name":"Harry Mulish","books":[{"id":2,"title":"De aanslag","highlighted":true,"publisher":'
            .  '{"id":2,"name":"Kosmos","books":[]}}]},{"id":5,"name":"Isaac Asimov","books":[]}]';
        $this->assertSame($expected, $client->getResponse()->getContent());
    }
}
