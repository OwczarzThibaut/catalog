<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use App\Model\OrderItemInterface;
use App\Entity\ProductInterface;

/**
 * OrderItem
 */
class OrderItem implements OrderItemInterface
{
    /**
     * @var ProductInterface
     */
    protected $product;

    /**
     * @var int
     */
    protected $quantity = 0;

    public function setProduct(ProductInterface $product): self
    {
    	$this->product = $product;
    	return $this;
    }

    public function getProduct(): ?ProductInterface
    {
    	return $this->product;
    }

    public function setQuantity(int $quantity): self
    {
    	$this->quantity = $quantity;
    	return $this;
    }

    public function getQuantity(): int
    {
    	if ($this->quantity < 0) {
    		$this->quantity = 0;
    	}
    	return $this->quantity;
    }

    public function addQuantity(int $add): self
    {
    	$this->quantity = $this->getQuantity() + $add;
    	return $this;
    }

    public function removeQuantity(int $remove): self
    {
    	$this->quantity = $this->getQuantity() - $remove;
    	return $this;
    }

    public function getPrice(): float
    {
        return (float) ($this->getProduct()->getPrix() * $this->getQuantity());
    }
}
