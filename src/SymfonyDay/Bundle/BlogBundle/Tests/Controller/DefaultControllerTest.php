<?php

namespace SymfonyDay\Bundle\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        // Set a crawler to make a fake request
        $crawler = $client->request('GET', '/blog');

        // Count instances with CSS3 syntax
        $this->assertEquals(2, $crawler->filter('.post')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Symfony Day")')->count());

        // Use a regexp to look for a certain word
        $response = $client->getResponse();
        $this->assertRegExp('/Second/', $response->getContent());

        // Check if there are more than five SQL queries
        $profile = $client->getProfile();
        $this->assertLessThanOrEqual(5, $profile->getCollector('db')->getQueryCount());
    }
}
