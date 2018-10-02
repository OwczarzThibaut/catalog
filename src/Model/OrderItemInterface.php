<?php

namespace App\Model;

use App\Entity\ProductInterface;

/**
 * OrderItemInterface
 */
interface OrderItemInterface
{
    public function setProduct(ProductInterface $product);

    public function getProduct();

    public function setQuantity(int $quantity);

    public function getQuantity();

    public function addQuantity(int $add);

    public function removeQuantity(int $remove);

    public function getPrice();
}
