<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Model\CartInterface;
use App\Model\Cart;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository, SessionInterface $session): Response
    {
        $products = $productRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $products,
            'cart' => $this->getCart($session)
        ]);
    }

    protected function getCart(SessionInterface $session): CartInterface
    {
        $cart = $session->get('cart');
        if (!($cart instanceof CartInterface)) {
            $cart = new Cart();
            $session->set('cart', $cart);
        }
        return $cart;
    }
}
