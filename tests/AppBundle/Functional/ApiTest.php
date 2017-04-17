<?php

namespace Test\AppBundle\Functional;

use Tests\AppBundle\BaseFixtureTest;

class ApiTest extends BaseFixtureTest
{
    /**
     * A simple test to check if non-existing routes give the correct response
     */
    public function testNonExistingAction()
    {
        $client = $this->makeClient();
        $client->request('GET', '/authors/');
        $this->assertSame(404, $client->getResponse()->getStatusCode());
    }
}
