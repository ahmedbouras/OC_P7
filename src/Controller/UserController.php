<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    /**
     * @Route("/clients/{clientId}/users/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser(UserRepository $userRepository, $clientId, $id)
    {
        $user = $userRepository->findOneBy(['client' => $clientId,'id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->json(null, 204);
    }

    /**
     * @Route("/clients/{id}/users", name="add_user", methods={"POST"})
     */
    public function addUser(Request $request, Client $client, SerializerInterface $serializer)
    {
        $user = new User();
        $jsonData = $request->getContent();
        $user = $serializer->deserialize($jsonData, User::class, 'json');
        $user->setClient($client);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->json('', 201);
        } catch (\Exception $e) {
            return $this->json('', 400);
        }
    }
}