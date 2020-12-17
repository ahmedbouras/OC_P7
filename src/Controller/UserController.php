<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/clients/{clientId}/users", name="show_users")
     */
    public function showUsers(UserRepository $userRepository, $clientId): Response
    {
        return $this->json(
            $userRepository->findBy(['client' => $clientId]),
            200,
            [],
            ['groups' => 'user_info']
        );
    }
}
