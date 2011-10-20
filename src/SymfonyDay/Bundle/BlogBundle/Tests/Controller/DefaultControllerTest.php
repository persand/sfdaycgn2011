<?php

/**
 * Run the terminal:
 * >phpunit -c app/phpunit.xml.dist
 *
 * Append the following to generate a HTML report
 * >phpunit -c app/phpunit.xml.dist --coverage-html ./coverage
 */

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

        // Click a link a move to another page
        $title = 'Welcome To The Symfony Day Conference';
        $link = $crawler
            ->selectLink($title)
            ->link()
        ;

        $crawler = $client->click($link);

        $this->assertEquals(1, $crawler->filter('title:contains("'.$title.'")')->count());
    }

    public function testBrowseToUnpublishedPost()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine')->getEntityManager();

        $post = $em
            ->createQueryBuilder()
            ->select('p')
            ->from('SymfonyDayBlogBundle:Post', 'p')
            ->where('p.publishedAt > :date')
            ->setParameter('date', date('Y-m-d H:i'))
            ->getQuery()
            ->getSingleResult()
        ;

        $client->request('GET', '/blog/'. $post->getId());
        $this->assertTrue($client->getResponse()->isNotFound());
    }
}
