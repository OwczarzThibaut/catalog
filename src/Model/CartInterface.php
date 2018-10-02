<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use App\Model\OrderItemInterface;

/**
 * CartInterface
 */
interface CartInterface
{
    public function setItems(ArrayCollection $items);
    
    public function getItems();

    public function getNumberItems();

    public function getPriceCart();

    public function addItem(OrderItemInterface $orderItem);

    public function removeItem(OrderItemInterface $orderItem);
}
