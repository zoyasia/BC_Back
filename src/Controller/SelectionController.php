<?php

namespace App\Controller;

use App\Repository\SelectionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SelectionController extends AbstractController
{

    public function __construct(private SelectionRepository $selectionRepository, private SerializerInterface $serializer, private UserRepository $userRepository)
    {}

    #[Route('/selections/{id}', name: 'app_selection', methods: ['GET'])]
    public function getCartByUserId(int $id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        
        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé.'], JsonResponse::HTTP_NOT_FOUND);
        }
        // Récupérez les sélections associées à cet utilisateur
        $selections = $this->selectionRepository->findBy(['user' => $user]);

        return $this->json($selections, 200, [], ['groups' => ['selection:read']]);

    }
}