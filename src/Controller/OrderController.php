<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\ArticleRepository;
use App\Repository\OrderRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{

    public function __construct(
        private OrderRepository $orderRepository, 
        private SerializerInterface $serializer, 
        private UserRepository $userRepository,
        private CartManager $cartManager,
        private ArticleRepository $articleRepository,
        private ServiceRepository $serviceRepository
        )
        {}

    #[Route('/api/order', name: 'app_order_create', methods: ['POST'])] 
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $order = new Order();
        $order
            ->setDropDate($data['dropDate'])
            ->setPickupDate($data['pickupDate'])
            ->setTotalPrice($data['totalPrice'])
            ->setCustomer($data['customer']);

        return $this->json(['order' => $order], Response::HTTP_CREATED);
    }
}
