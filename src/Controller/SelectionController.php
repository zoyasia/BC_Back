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

    #[Route('/api/selection', name: 'app_selection_create', methods: ['POST'])] // IsGranted
    public function create(Request $request, UserInterface $user): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $article = $this->articleRepository->findOneBy(['id' => $data['article_id']]);
            $quantity = $data['quantity'];
    
            $service = $this->serviceRepository->findOneBy(['id' => $data['service_id']]);
    
            $newSelection = $this->cartManager->createNewSelection($article, $quantity, $user, $service);
    
            return $this->json($newSelection, 201, [], ['groups' => ['selection:read']]);
        }  catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }

    }

    #[Route('/api/selection/{id}', name: 'app_selection_update', methods: ['PATCH'])]
    public function updateSelection(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Récupère la sélection existante depuis la base de données
        $selection = $this->selectionRepository->find($id);

        if (!$selection) {
            return new JsonResponse(['error' => 'Sélection non trouvée'], 404);
        }

        // Appelle la méthode du CartManager pour mettre à jour la quantité
        $this->cartManager->updateSelectionQuantity($selection, $data['quantity']);

        return $this->json($selection, 200, [], ['groups' => ['selection:read']]);
    }
}
