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
                ->setPrix($item['prix'])
                ->setImage($item['image']);
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
        $images = $this->getImages();
        $image = $images[rand(0, count($images)-1)];
        $randstring = substr(md5(rand()), 0, 7);
        $nom = "Fixture ".$randstring;
        $description = "Description de la ".$nom;
        $prix = (float)(rand(100, 10000)/100);
        return [
            "nom" => $nom,
            "description" => $description,
            "prix" => $prix,
            "image" => $image
        ];
    }

    protected function getImages()
    {
        return [
            "https://www.souffledor.fr/themes/indd/assets/img/default_image.jpg",
            "https://nato-pa.int/sites/default/files/default_images/default-image.jpg",
            "https://www.nesta.fr/media/catalog/product/cache/1/small_image/504x504/9df78eab33525d08d6e5fb8d27136e95/placeholder/default/default-img-prod-300.jpg",
            "https://www.kskscollectibles.com/skin/frontend/default/sns_xsport/images/catalog/product/placeholder/image.jpg",
            "https://www.boutique-cuir.fr/media/catalog/product/cache/1/image/600x600/9df78eab33525d08d6e5fb8d27136e95/placeholder/default/np_more_img.gif"
        ];
    }
}
