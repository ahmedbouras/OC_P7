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
     * @Route("/clients/{clientId}/users", name="show_users", methods={"GET"})
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

    /**
     * @Route("/clients/{clientId}/users/{id}", name="show_user", methods={"GET"})
     */
    public function showUser(UserRepository $userRepository, $clientId, $id): Response
    {
        return $this->json(
            $userRepository->findOneBy([
                'client' => $clientId,
                'id' => $id
                ]),
            200,
            [],
            ['groups' => 'user_info']
        );
    }
}
