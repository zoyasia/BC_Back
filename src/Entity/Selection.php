<?php

namespace App\Entity;

// use ApiPlatform\Metadata\ApiResource;
use App\Repository\SelectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SelectionRepository::class)]
// #[ApiResource(normalizationContext:['groups'=>['selection:read']])]
class Selection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['selection:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['selection:read'])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['selection:read'])]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'selections')]
    #[Groups(['selection:read'])]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'selections')]
    #[Groups(['selection:read'])]
    private ?Service $service = null;

    #[ORM\ManyToOne(inversedBy: 'selection')]
    #[Groups(['selection:read'])]
    private ?Order $orders = null;

    #[ORM\ManyToOne(inversedBy: 'selections')]
    #[Groups(['selection:read'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
