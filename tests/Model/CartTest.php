<?php

namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use App\Model\Cart;
use App\Model\OrderItem;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;

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

    public function testItemsInCart()
    {
        $cart = new Cart();
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
        $orderItemCopy = new OrderItem();
        $orderItemCopy
            ->setProduct($product)
            ->setQuantity($number);

        $cart->addItem($orderItem);
        $cart->addItem($orderItemCopy);

        $this->assertEquals(($number + $number), $cart->getNumberItems());

        $cart->removeItem($orderItemCopy);

        $this->assertEquals($number, $cart->getNumberItems());
    }

    public function testResetCart()
    {
        $cart = new Cart();
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
        $orderItemCopy = new OrderItem();
        $orderItemCopy
            ->setProduct($product)
            ->setQuantity($number);

        $cart->addItem($orderItem);
        $cart->addItem($orderItemCopy);

        $this->assertEquals(($number + $number), $cart->getNumberItems());
        $cart->resetCart();
        $resultItem = 0;
        $numberItem = 0;
        $this->assertEquals((float)$resultItem, $cart->getPriceCart());
        $this->assertEquals((float)$numberItem, $cart->getNumberItems());
    }

    public function testSetItemsCart()
    {
        $cart = new Cart();
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
        $orderItemCopy = new OrderItem();
        $orderItemCopy
            ->setProduct($product)
            ->setQuantity($number);

        $items = new ArrayCollection();
        $items->add($orderItem);
        $items->add($orderItemCopy);

        $cart->setItems($items);
        $this->assertEquals(($number + $number), $cart->getNumberItems());
    }

    public function testGetItemByProductCart()
    {

        $cart = new Cart();
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
        $orderItemCopy = new OrderItem();
        $orderItemCopy
            ->setProduct($product)
            ->setQuantity($number);

        $cart->addItem($orderItem);
        $cart->addItem($orderItemCopy);

        $getOrderItem = new OrderItem();
        $getOrderItem
            ->setProduct($product)
            ->setQuantity($number + $number);
        $this->assertEquals($getOrderItem, $cart->getItemByProduct($product));
        
        $cart->resetCart();
        $this->assertEquals(null, $cart->getItemByProduct($product));
    }

    public function testNegativeQuantityCart()
    {

        $cart = new Cart();
        $randstring = substr(md5(rand()), 0, 7);
        $nom = "Fixture ".$randstring;
        $description = "Description de la ".$nom;
        $prix = (float)(rand(100, 10000)/100);
        $number = (-1)*rand(2, 100);

        $product = new Product();
        $product
            ->setNom($nom)
            ->setDescription($description)
            ->setPrix($prix);

        $orderItem = new OrderItem();
        $orderItem
            ->setProduct($product)
            ->setQuantity($number);
        $orderItemCopy = new OrderItem();
        $orderItemCopy
            ->setProduct($product)
            ->setQuantity($number);

        $cart->addItem($orderItem);
        $cart->addItem($orderItemCopy);

        $resultItem = 0;
        $numberItem = 0;
        $getOrderItem = new OrderItem();
        $getOrderItem
            ->setProduct($product)
            ->setQuantity($numberItem);
            
        $this->assertEquals($getOrderItem, $cart->getItemByProduct($product));
        $this->assertEquals((float)$resultItem, $cart->getPriceCart());
        $this->assertEquals((float)$numberItem, $cart->getNumberItems());
    }
}
