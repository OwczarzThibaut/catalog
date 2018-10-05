<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use App\Model\CartInterface;
use App\Model\OrderItemInterface;
use App\Entity\ProductInterface;

/**
 * Cart
 */
class Cart implements CartInterface
{
    /**
     * @var ArrayCollection
     */
    protected $items;

    public function setItems(ArrayCollection $cartItems): self
    {
        foreach ($cartItems as $cartItem) {
            if ($cartItem instanceof OrderItemInterface) {
                $this->addItem($cartItem);
            }
        }
        return $this;
    }
    
    public function getItems(): ArrayCollection
    {
        if (!($this->items instanceof ArrayCollection)) {
            $this->items = new ArrayCollection();
        }
        return $this->items;        
    }

    public function getNumberItems(): int
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->getQuantity();
        }
        return $total;
    }

    public function getPriceCart(): float
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->getPrice();
        }
        return (float)$total;       
    }

    public function addItem(OrderItemInterface $orderItem): self
    {
        $found = false;
        $items = $this->getItems();
        foreach ($items as $item) {
            if ($item->getProduct() == $orderItem->getProduct()) {
                $this->getItems()->removeElement($item);
                $item->addQuantity($orderItem->getQuantity());
                $this->getItems()->add($item);
                $found = true;
            }
        }
        if (false === $found) {
            $this->getItems()->add($orderItem);
        }
        return $this;
    }

    public function removeItem(OrderItemInterface $orderItem): self
    {
        $items = $this->getItems();
        foreach ($items as $item) {
            if ($item->getProduct() == $orderItem->getProduct()) {
                $this->getItems()->removeElement($item);
                $item->removeQuantity($orderItem->getQuantity());
                if ($item->getQuantity() > 0) {
                    $this->getItems()->add($item);
                }
            }
        }
        return $this;
    }

    public function getItemByProduct(ProductInterface $product): ?OrderItemInterface
    {
        foreach ($this->getItems() as $item) {
            if ($item->getProduct() == $product) {
                return $item;
            }
        }
        return null;
    }

    public function resetCart()
    {
        $this->items = new ArrayCollection();
        return $this;
    }
}
