<?php

namespace Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    public function testProduct()
    {
        $randstring = substr(md5(rand()), 0, 7);
        $nom = "Fixture ".$randstring;
        $description = "Description de la ".$nom;
        $image = "image du produit ".$nom;
        $prix = (float)(rand(100, 10000)/100);
        $number = rand(2, 100);
        $slug = "";

        $product = new Product();
        $product
            ->setNom($nom)
            ->setDescription($description)
            ->setPrix($prix)
            ->setImage($image);
    
        $this->assertEquals($nom, $product->getNom());
        $this->assertEquals($description, $product->getDescription());
        $this->assertEquals($prix, $product->getPrix());
        $this->assertEquals($image, $product->getImage());


        $productArray = [
            "id" => null,
            "nom" => $nom,
            "description" => $description,
            "image" => $image,
            "slug" => $slug
        ];
        $this->assertEquals($productArray, $product->toArray());
    }


    // public function testSlug()
    // {
    //      /* For slug need to catch event onFlush because slug is defined at this moment, so for test i write slug here directly */
    // }
}
