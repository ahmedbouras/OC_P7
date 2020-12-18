<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="show_products", methods={"GET"})
     */
    public function showProducts(ProductRepository $productRepository): Response
    {
        return $this->json($productRepository->findAll(), 200);
    }

    /**
     * @Route("/products/{id}", name="show_product", methods={"GET"})
     */
    public function showProduct(ProductRepository $productRepository, $id): Response
    {
        return $this->json($productRepository->findOneBy(['id' => $id]), 200);
    }
}
