<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $users = $this->userManager->getAll();
        return $this->json($users);
    }

    #[Route('/users', name: 'app_create', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->userManager->create(
            $data['firstname'],
            $data['lastname'],
            $data['email'],
            $data['plainPassword'],
        );

        return $this->json(['user' => $user], Response::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'app_user', methods: ['GET'])]
    public function showUser(int $id): JsonResponse
    {
        $user = $this->userManager->getUserById($id);

        if ($user) {
            return $this->json($user);
        } else {
            return $this->json(['message' => "L'utilisateur n'a pas été trouvé"], 404);
        }
    }

    #[Route('/users/{id}', name: 'app_update', methods: ['PATCH'])]
    public function updateUser(User $user, Request $request): JsonResponse
    {
        $this->userManager->update($user, $request->toArray());
        return new JsonResponse($user, Response::HTTP_OK);
        // return $this->json($user, 204);
    }

}
