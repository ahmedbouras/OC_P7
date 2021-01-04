<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
 * @Route("/api", name="api_")
 */
class SecurityController extends AbstractFOSRestController
{
    /**
     * Get a token to access to all endpoints
     * @Rest\Post("/login_check", name="login")
     * @OA\Tag(name="Authentication")
     * @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          @OA\Property(type="string", property="username"),
     *          @OA\Property(type="string", property="password"),
     *          required={"username", "password"}
     *      )
     * )
     * @OA\Response(
     *     response=200,
     *     description="return a token",
     *      @OA\JsonContent(
     *          @OA\Property(type="string", property="token")
     *      )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Error in body request." 
     * )
     * @OA\Response(
     *     response=401,
     *     description="Invalid credentials." 
     * )
     */
    public function api_login()
    {
        
    }
}