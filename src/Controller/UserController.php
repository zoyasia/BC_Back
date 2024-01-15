<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    public function __construct(private UserManager $userManager, private SerializerInterface $serializer, private UserRepository $userRepository, private Security $security)
    {}

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

    #[Route('/api/users/me', name: 'app_user', methods: ['GET'])]
    public function showUser(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user instanceof UserInterface) {
            // L'utilisateur n'est pas connecté
            throw new BadRequestHttpException('Aucun utilisateur connecté');
        }

        return $this->json($user, 200, [], ['groups' => ['user:read']]);
    }

    #[Route('/users/{id}', name: 'app_update', methods: ['PATCH'])]
    public function updateUser(User $user, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->userManager->update(
            $user,
            $data['firstname'] ?? null,
            $data['lastname'] ?? null,
            $data['email'] ?? null,
            $data['gender'] ?? null,
            $data['birthdate'] ?? null,
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $data['zipcode'] ?? null,
            $data['city'] ?? null,
            $data['newPassword'] ?? null
        );

        return $this->json(['user' => $user], Response::HTTP_NO_CONTENT);
    }

    // Faire des vérifications côté Controller de ce qui est envoyé par le front.
    // Passer des entités en paramètre plutôt qu'un id, et si User trouvé, faire appel au service

    #[Route('/users/{id}', name: 'app_delete', methods: ['DELETE'])]
    public function deleteUser(int $id): JsonResponse
    {
        $this->userManager->delete($id);
        return new JsonResponse($id, Response::HTTP_NO_CONTENT);
    }

}
