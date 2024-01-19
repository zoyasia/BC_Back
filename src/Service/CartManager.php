<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Selection;
use App\Entity\Service;
use App\Entity\User;
use App\Repository\SelectionRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartManager
{
    /**
     * @var SelectionRepository
     */
    private $selectionRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        SelectionRepository $selectionRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->selectionRepository = $selectionRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Create a new selection
     *
     * @param Article $article
     * @param int $quantity
     * @param User $user
     * @param Service $service
     * @return Selection
     */
    public function createNewSelection(Article $article, int $quantity, User $user, Service $service): Selection
    {
        $selectionPrice = (($article->getPrice() + $service->getPrice()) * $quantity);
        $selection = new Selection();
        $selection->setArticle($article);
        $selection->setQuantity($quantity);
        $selection->setUser($user);
        $selection->setService($service);
        $selection->setPrice($selectionPrice);

        $this->entityManager->persist($selection);
        $this->entityManager->flush();

        return $selection;
    }

    /**
     * Update the quantity of an existing selection
     *
     * @param Selection $selection
     * @param int $newQuantity
     * @return Selection
     */
    public function updateSelectionQuantity(Selection $selection, int $newQuantity): Selection
    {
        $selectionPrice = (($selection->getArticle()->getPrice() + $selection->getService()->getPrice()) * $newQuantity);

        $selection->setQuantity($newQuantity);
        $selection->setPrice($selectionPrice);

        $this->entityManager->flush();

        return $selection;
    }
}