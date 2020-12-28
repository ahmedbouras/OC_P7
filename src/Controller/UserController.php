<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *      path="/clients/{clientId}/users",
     *      name="list_users",
     *      requirements={"clientId"="\d+"}
     * )
     * @Rest\View(
     *      statusCode=200
     * )
     */
    public function listAction(UserRepository $userRepository, $clientId)
    {
        $users = $userRepository->findBy(['client' => $clientId]);
        return $users;
    }

    /**
     * @Rest\Get(
     *      path="/clients/{clientId}/users/{id}",
     *      name="show_user",
     *      requirements={"clientId"="\d+", "id"="\d+"}
     * )
     * @Rest\View(
     *      statusCode=200
     * )
     */
    public function showAction(UserRepository $userRepository, $clientId, $id)
    {
        $user = $userRepository->findOneBy(['client' => $clientId, 'id' => $id]);
        return $user;
    }

    /**
     * @Rest\Delete(
     *      path="/clients/{clientId}/users/{id}",
     *      name="delete_user",
     *      requirements={"clientId"="\d+", "id"="\d+"}
     * )
     * @Rest\View(
     *      statusCode=204
     * )
     */
    public function deleteAction(UserRepository $userRepository, $clientId, $id)
    {
        $user = $userRepository->findOneBy(['client' => $clientId,'id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
    }

    /**
     * @Rest\Post(
     *      path="/clients/{id}/users",
     *      name="create_user",
     *      requirements={"id"="\d+"}
     * )
     * @Rest\View(
     *      statusCode=201
     * )
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function createAction(User $user, ClientRepository $clientRepository, $id)
    {
        $client = $clientRepository->findOneBy(['id' => $id]);
        if ($client) {
            $user->setClient($client);

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $user;
            } catch (\Exception $e) {
                return $this->json('Erreur bdd', 400);
            }
        } else {
            return $this->json('client inconnu', 404);
        }
    }
}
