<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Representation\Entities;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

/**
 * @Route("/api", name="api_")
 */
class ProductController extends AbstractFOSRestController
{
    /**
     * Get list of all products
     * @Rest\Get("/products", name="list_products")
     * @Rest\QueryParam(
     *      name="page",
     *      requirements="\d+",
     *      default="1"
     * )
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="The page's number.",
     *     @OA\Schema(type="int")
     * )
     * @Rest\QueryParam(
     *      name="limit",
     *      requirements="\d+",
     *      default="10"
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Limit of items per page.",
     *     @OA\Schema(type="int")
     * )
     * @Rest\QueryParam(
     *      name="order",
     *      requirements="asc|desc",
     *      default="asc",
     *      description="Sort order (asc or desc)"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Return the products' list of BileMo",
     *     @Model(type=Product::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found | Invalid JWT Token | Expired JWT Token"
     * )
     * @OA\Tag(name="Products")
     * @Security(name="Bearer")
     * @Rest\View(statusCode=200)
     */
    public function listAction(ParamFetcherInterface $paramFetcher, ProductRepository $productRepository)
    {
        $pager = $productRepository->search(
            $paramFetcher->get('page'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('order')
        );
        return new Entities($pager);
    }

    /**
     * Get details about a product
     * @Rest\Get(
     *      path="/products/{id}",
     *      name="show_product",
     *      requirements={"id"="\d+"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Return a specific product thanks to its id",
     *     @Model(type=Product::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="JWT Token not found | Invalid JWT Token | Expired JWT Token"
     * )
     * @OA\Tag(name="Products")
     * @Security(name="Bearer")
     * @Rest\View(statusCode=200)
     */
    public function showAction(Product $product)
    {
        return $product;
    }
}
