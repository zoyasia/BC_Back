<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Service;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\SelectionRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SelectionController extends AbstractController
{

    public function __construct(
    private SelectionRepository $selectionRepository, 
    private SerializerInterface $serializer, 
    private UserRepository $userRepository,
    private CartManager $cartManager,
    private ArticleRepository $articleRepository,
    private ServiceRepository $serviceRepository
    )
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

    #[Route('/api/selections', name: 'app_selection', methods: ['POST'])] // IsGranted
    public function addItemToCart(Request $request, UserInterface $user): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $article = $this->articleRepository->findOneBy(['id' => $data['article']]);
        $quantity = $data['quantity'];

        $service = $this->serviceRepository->findOneBy(['id' => $data['service']]);

        $newSelection = $this->cartManager->createNewSelection($article, $quantity, $user, $service);

        return $this->json($newSelection, 201, [], ['groups' => ['selection:read']]);
    }


}