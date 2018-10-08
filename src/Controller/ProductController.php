<?php

namespace App\Controller;

use App\Controller\HomeController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProductController extends HomeController
{
    /**
     * @Route("/product/{slug}", name="productView")
     */
    public function productView(string $slug, ProductRepository $productRepository, SessionInterface $session): Response
    {
        $product = $productRepository->findOneBySlug($slug);
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product,
            'cart' => $this->getCart($session)
        ]);
    }
}
