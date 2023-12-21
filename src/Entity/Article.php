<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["articles:read", "categories:read", "services:read"])] // j'inclus la propriété id à mon groupe de sérialisation articles:read
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["articles:read", "categories:read", "services:read", "selections:read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["articles:read", "services:read"])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["articles:read"])]
    private ?string $state = null;

    #[ORM\Column]
    #[Groups(["articles:read", "categories:read", "services:read", "selections:read"])]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Selection::class)]
    private Collection $selections;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[Groups(["articles:read"])]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'articles')]
    private Collection $services;

    public function __construct()
    {
        $this->selections = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

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

    /**
     * @return Collection<int, Selection>
     */
    public function getSelections(): Collection
    {
        return $this->selections;
    }

    public function addSelection(Selection $selection): static
    {
        if (!$this->selections->contains($selection)) {
            $this->selections->add($selection);
            $selection->setArticle($this);
        }

        return $this;
    }

    public function removeSelection(Selection $selection): static
    {
        if ($this->selections->removeElement($selection)) {
            // set the owning side to null (unless already changed)
            if ($selection->getArticle() === $this) {
                $selection->setArticle(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    #[Groups(["articles:read"])]
    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        $this->services->removeElement($service);

        return $this;
    }
}
