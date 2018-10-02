<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function loadData()
    {
        $loader = new sfPropelData();
        $loader->loadData(sfConfig::get('sf_test_dir').'/fixtures');

        return $this;
    }
    public function testHomePage()
    {
        $client = static::createClient([],['HTTP_HOST' => 'localhost:8000']);

        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $container = self::$container;
        $nbProducts = $container->getParameter('max_homepage_products');
        $crawler = $client->request('GET', '/');

        $this->assertEquals($nbProducts,  $crawler->filter('div.product')->count());
    }
}
