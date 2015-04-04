<?php

class ResponseTest extends TestCase {

    const LOGIN_URL = '/login';

    /**
     * Test authenticated visitor to homepage
     *
     * @return void
     */
    public function testAuthVisitor()
    {
        Auth::loginUsingId(1);
        $crawler = $this->client->request('GET', self::LOGIN_URL);
        $response = $this->client->getResponse()->isOK();

        $this->assertTrue($response);
    }

    /**
     * Test non-authenticated visitor to homepage
     *
     * @return void
     */
    public function testNonAuthVisitor()
    {
        Auth::logout();
        $this->client->request('GET', self::LOGIN_URL);

        $response = $this->client->getResponse();
        $this->assertTrue($response->getStatusCode() === 200);
    }
}
