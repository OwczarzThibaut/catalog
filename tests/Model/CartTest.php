<?php

namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use App\Model\Cart;
use App\Model\OrderItem;
use App\Entity\Product;

class CartTest extends TestCase
{
    public function testGetPriceCart()
    {
        $cart = new Cart();
        $result = 0;
        $this->assertEquals((float)$result, $cart->getPriceCart());

        $randstring = substr(md5(rand()), 0, 7);
        $nom = "Fixture ".$randstring;
        $description = "Description de la ".$nom;
        $prix = (float)(rand(100, 10000)/100);
        $number = rand(2, 100);

        $product = new Product();
        $product
            ->setNom($nom)
            ->setDescription($description)
            ->setPrix($prix);

        $orderItem = new OrderItem();
        $orderItem
            ->setProduct($product)
            ->setQuantity($number);

        $cart->addItem($orderItem);
        $this->assertEquals((float)($number * $prix), $cart->getPriceCart());
    }

}
