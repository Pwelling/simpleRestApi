<?php

namespace Test\AppBundle\Functional;

use Tests\AppBundle\BaseFixtureTest;

class BookControllerTest extends BaseFixtureTest
{
    /**
     * A simple test to check if non-existing routes give the correct response
     */
    public function testHighlightedAction()
    {
        $client = $this->makeClient();
        $client->request('GET', '/books/highlighted');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $expected =
            '[{"id":2,"title":"De aanslag","highlighted":true,"author":{"id":4,"name":"Harry Mulish",'
            .   '"books":[]},"publisher":{"id":2,"name":"Kosmos","books":[]}}]';
        $this->assertSame($expected, $client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\BookController::getAction
     */
    public function testGetAction()
    {
        $client = $this->makeClient();
        $client->request('GET', '/books/1');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $expected =
            '{"id":1,"title":"It","highlighted":false,"author":{"id":1,"name":"Stephen King","books":[]}'
            .  ',"publisher":{"id":1,"name":"Harlekijn","books":[]}}';
        $this->assertSame($expected, $client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\BookController::getAction
     */
    public function testGetActionNotFound()
    {
        $client = $this->makeClient();
        $client->request('GET', '/books/22');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('["Book not found"]', $client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\BookController::searchAction
     * @covers \AppBundle\Repository\BookRepository::findByKeyword
     */
    public function testSearchAction()
    {
        // First search is on a known title
        $client = $this->makeClient();
        $client->request('GET', '/books/search/it');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $expected =
            '[{"id":1,"title":"It","highlighted":false,"author":{"id":1,"name":"Stephen King","books":[]},'
            .    '"publisher":{"id":1,"name":"Harlekijn","books":[]}}]';
        $this->assertSame($expected, $client->getResponse()->getContent());

        // Second search is on a publisher
        $client = $this->makeClient();
        $client->request('GET', '/books/search/elastique');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $expected =
            '[{"id":3,"title":"Terug naar Oegstgeest","highlighted":false,"author":{"id":2,"name":"Jane Wolkers",'
            .   '"books":[]},"publisher":{"id":3,"name":"Elastique","books":[]}}]';
        $this->assertSame($expected, $client->getResponse()->getContent());

        // Third search is on an author
        $client = $this->makeClient();
        $client->request('GET', '/books/search/mulish');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $expected =
            '[{"id":2,"title":"De aanslag","highlighted":true,"author":{"id":4,"name":"Harry Mulish","books":[]},'
            .    '"publisher":{"id":2,"name":"Kosmos","books":[]}}]';
        $this->assertSame($expected, $client->getResponse()->getContent());

        // Final search for a not found keyword
        $client = $this->makeClient();
        $client->request('GET', '/books/search/pokemon');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('["No books found"]', $client->getResponse()->getContent());
    }

    /**
     * @covers \AppBundle\Controller\BookController::searchAction
     * @covers \AppBundle\Repository\BookRepository::findByKeyword
     */
    public function testSearchActionWithLimitAndOffset()
    {
        $client = $this->makeClient();
        $client->request('GET', '/books/search/i/0/2');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $expected1 =
            '[{"id":1,"title":"It","highlighted":false,"author":{"id":1,"name":"Stephen King","books":[]},'
            .    '"publisher":{"id":1,"name":"Harlekijn","books":[]}},'
            .    '{"id":3,"title":"Terug naar Oegstgeest","highlighted":false,"author":{"id":2,"name":'
            .    '"Jane Wolkers","books":[]},"publisher":{"id":3,"name":"Elastique","books":[]}}]';
        $this->assertSame($expected1, $client->getResponse()->getContent());

        // A second test with a different offset
        $client2 = $this->makeClient();
        $client2->request('GET', '/books/search/i/1/1');
        $this->assertSame(200, $client2->getResponse()->getStatusCode());
        $expected2 =
            '[{"id":3,"title":"Terug naar Oegstgeest","highlighted":false,"author":{"id":2,"name":"Jane Wolkers",'
            .    '"books":[]},"publisher":{"id":3,"name":"Elastique","books":[]}}]';
        $this->assertSame($expected2, $client2->getResponse()->getContent());
    }
}
