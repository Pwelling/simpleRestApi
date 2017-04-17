<?php

namespace Test\AppBundle\Functional;

use Tests\AppBundle\BaseFixtureTest;

class PublisherControllerTest extends BaseFixtureTest
{
    /**
     * @covers \AppBundle\Controller\PublisherController::getAction
     */
    public function testGetAction()
    {
        $client = $this->makeClient();
        $client->request('GET', '/publishers/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $expected =
            '{"id":1,"name":"Harlekijn","books":[{"id":1,"title":"It","highlighted":false,"author":'
            . '{"id":1,"name":"Stephen King","books":[]}}]}';
        $this->assertSame($expected, $client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\PublisherController::getAction
     */
    public function testGetActionNotFound()
    {
        $client = $this->makeClient();
        $client->request('GET', '/publishers/22');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame('["Publisher not found"]', $client->getResponse()->getContent());
    }


    /**
     * @covers \AppBundle\Controller\PublisherController::listAction
     */
    public function testListAction()
    {
        $client = $this->makeClient();
        $client->request('GET', '/publishers/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $expected =
            '[{"id":1,"name":"Harlekijn","books":[{"id":1,"title":"It","highlighted":false,"author":'
            .    '{"id":1,"name":"Stephen King","books":[]}}]},{"id":2,"name":"Kosmos","books":['
            .    '{"id":2,"title":"De aanslag","highlighted":true,"author":{"id":4,"name":"Harry Mulish","books":[]}'
            .    '}]},{"id":3,"name":"Elastique","books":[{"id":3,"title":"Terug naar Oegstgeest",'
            .    '"highlighted":false,"author":{"id":2,"name":"Jane Wolkers","books":[]}}]},'
            .    '{"id":4,"name":"Boekengilde","books":[]},{"id":5,"name":"Boekencentrum","books":[]},'
            .    '{"id":6,"name":"Meulenhoff","books":[]},{"id":7,"name":"Ailantus","books":[]}'
            .    ',{"id":8,"name":"Aspekt","books":[]}]';
        $this->assertSame($expected, $client->getResponse()->getContent());
    }
}
