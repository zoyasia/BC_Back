<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
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
    {
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

    #[Route('/api/users/me', name: 'app_update', methods: ['PATCH'])]
    public function updateUser(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!$user instanceof UserInterface) {
            // L'utilisateur n'est pas connecté
            throw new BadRequestHttpException('Aucun utilisateur connecté');
        }

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

    #[Route('/api/users/me', name: 'app_delete', methods: ['DELETE'])]
    public function deleteUser(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();

        if (!$user instanceof UserInterface) {
            // L'utilisateur n'est pas connecté
            throw new BadRequestHttpException('Aucun utilisateur connecté');
        }

        // Supprimer l'utilisateur
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
