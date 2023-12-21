<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'app_articles', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json(
            $articleRepository->findAll(),
            context: ['groups' => 'articles:read']
        );
    }
}
