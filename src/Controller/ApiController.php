<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/products", name="api_product")
     */
    public function index(SerializerInterface $serializer, ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();
        $repr = $serializer->serialize($products, 'json');

        return JsonResponse::fromJsonString($repr, 200);
    }
}
