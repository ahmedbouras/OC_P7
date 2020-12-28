<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *      path="/products", 
     *      name="list_products"
     * )
     * @Rest\View(statusCode=200)
     */
    public function listAction(ProductRepository $productRepository)
    {
        $articles = $productRepository->findAll();
        return $articles;
    }

    /**
     * @Rest\Get(
     *      path="/products/{id}",
     *      name="show_product",
     *      requirements={"id"="\d+"}
     * )
     * @Rest\View(statusCode=200)
     */
    public function showAction(Product $product)
    {
        return $product;
    }
}
