<?php

namespace SymfonyDay\Bundle\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog');

        $this->assertEquals(2, $crawler->filter('.post')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Symfony Day")')->count());

        $response = $client->getResponse();
        $this->assertRegExp('/Second/', $response->getContent());
    }
}
