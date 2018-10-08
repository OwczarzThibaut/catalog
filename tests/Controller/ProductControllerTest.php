<?php

namespace Tests\Controller;

use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function loadData()
    {
        $loader = new sfPropelData();
        $loader->loadData(sfConfig::get('sf_test_dir').'/fixtures');

        return $this;
    }
    /*
     * Need To mock service Product Repository for have a checked result
     * and display page with this information
     */
    /*
    public function testProductPage()
    {
        $randstring = substr(md5(rand()), 0, 7);
        $nom = "Fixture ".$randstring;
        $description = "Description de la ".$nom;
        $image = "https://www.digitalcitizen.life/sites/default/files/styles/img_u_large/public/featured/2016-08/photo_gallery.jpg";
        $prix = (float)(rand(100, 10000)/100);
        $number = rand(2, 100);
        $slug = "fixture-".$randstring;

        $product = new Product();
        $product
            ->setNom($nom)
            ->setDescription($description)
            ->setPrix($prix)
            ->setImage($image)
            ->setSlug($slug);
        
        $productRepository = $this->getMockBuilder(ProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('findOneBySlug')
            ->willReturn($product);

        $client = static::createClient([
                'services' => [
                    "ProductRepository" => $productRepository
                ]
            ],
            ['HTTP_HOST' => 'localhost:8000']
        );
        $client->request('GET', '/fr/product/'.$slug);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $container = self::$container;
        $client->request('GET', '/fr/product/'.$slug);
        $this->assertEquals(1,  $crawler->filter('div.product')->count());
        $this->assertEquals($nom,  $crawler->filter('h5'));
    }
    */
}
