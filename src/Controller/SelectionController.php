<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SelectionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SelectionController extends AbstractController
{

    public function __construct(private SelectionRepository $selectionRepository, private SerializerInterface $serializer, private UserRepository $userRepository)
    {}

    #[Route('/api/selections', name: 'app_selection', methods: ['GET'])] // IsGranted
    /**
     * @param User $user
     * Indique que UserInterface étend mon entité User, et on peut donc accéder à la méthode getId de User 
     */
    public function getCartByUserId(UserInterface $user): JsonResponse
    {
        // Récupère les sélections associées à cet utilisateur
        $selections = $this->selectionRepository->findBy(['user' => $user->getId()]);

        return $this->json($selections, 200, [], ['groups' => ['selection:read']]);

    }
}