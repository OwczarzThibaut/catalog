<?php

namespace App\Controller;

use App\Controller\HomeController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Model\OrderItem;
use App\Model\OrderItemInterface;
use App\Form\Type\OrderItemType;
use App\Form\Type\OrderItemQuantityType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;

class CartController extends HomeController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function cartView(SessionInterface $session): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $this->getCart($session)
        ]);
    }

    public function OrderItemForm(Product $product): Response
    {
        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $form = $this->createForm(OrderItemType::class, $orderItem);
        return $this->render('cart/item_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function OrderItemQuantityForm(Product $product, int $quantity): Response
    {
        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setQuantity($quantity);
        $form = $this->createForm(OrderItemQuantityType::class, $orderItem);
        return $this->render('cart/item_form_quantity.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cart/reset", name="reset_cart")
     */
    public function resetCart(SessionInterface $session): Response
    {
        $cart = $this->getCart($session);
        $cart->resetCart();
        $session->set('cart', $cart);
        return $this->redirectToRoute('cart');
    }


    /**
     * @Route("/cart/add", name="add_cart", methods={"POST"})
     */
    public function addCart(Request $request, SessionInterface $session): Response
    {
        $orderItem = new OrderItem();
        $form = $this->createForm(OrderItemType::class, $orderItem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $this->getCart($session);
            $cart->addItem($form->getData());
            $session->set('cart', $cart);
        }
        return $this->redirect($request->headers->get('referer'));
    }


    /**
     * @Route("/cart/update", name="update_cart_quantity", methods={"POST"})
     */
    public function updateCart(SessionInterface $session, Request $request)
    {
        $orderItem = new OrderItem();
        $form = $this->createForm(OrderItemQuantityType::class, $orderItem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $this->getCart($session);
            $orderItemCart = $cart->getItemByProduct($orderItem->getProduct());
            if ($orderItemCart instanceof OrderItemInterface) {
                $cart->removeItem($orderItemCart);
                $cart->addItem($form->getData());
                $session->set('cart', $cart);
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cart/remove/{id}", name="remove_cart")
     */
    public function removeProduct(int $id, ProductRepository $productRepository, SessionInterface $session, Request $request): Response
    {
        $product = $productRepository->findOneById($id);
        if ($product instanceof ProductInterface) {
            $cart = $this->getCart($session);
            $orderItem = $cart->getItemByProduct($product);
            if ($orderItem instanceof OrderItemInterface) {
                $cart->removeItem($orderItem);
                $session->set('cart', $cart);
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
