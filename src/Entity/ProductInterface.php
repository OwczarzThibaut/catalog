<?php

namespace App\Entity;

/**
 * ProductInterface
 */
interface ProductInterface
{
    public function getId();

    public function getNom();

    public function setNom(string $nom);

    public function getDescription();

    public function setDescription(string $description);

    public function getPrix();

    public function setPrix(float $prix);

    public function getImage();

    public function setImage(string $image);
    
    public function getSlug();

    public function setSlug(string $slug);

    public function toArray();
}
