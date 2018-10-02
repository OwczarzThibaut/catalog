<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;

class Catalog extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fixtures = $this->getFixtures();
        foreach ($fixtures as $item) {
            $product = new Product();
            $product
                ->setNom($item['nom'])
                ->setDescription($item['description'])
                ->setPrix($item['prix']);
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getFixtures($numberMax = 12)
    {
        $return = [];
        for ($i = 0; $i< $numberMax; $i++) {
            $return[] = $this->getOneFixture();
        }
        return $return;
    }

    protected function getOneFixture()
    {
        $randstring = substr(md5(rand()), 0, 7);
        $nom = "Fixture ".$randstring;
        $description = "Description de la ".$nom;
        $prix = (float)(rand(100, 10000)/100);
        return [
            "nom" => $nom,
            "description" => $description,
            "prix" => $prix
        ];
    }
}
