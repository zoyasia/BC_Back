<?php

namespace App\Entity;

// use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
// #[ApiResource(normalizationContext:['groups'=>['services:read']])] 
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['services:read', 'selection:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['services:read', 'selection:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['services:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['services:read','selection:read'])]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Selection::class)]
    private Collection $selections;

    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'services')]
    #[Groups(['services:read'])]
    private Collection $articles;

    public function __construct()
    {
        $this->selections = new ArrayCollection();
        $this->articles = new ArrayCollection();
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
            $selection->setService($this);
        }

        return $this;
    }

    public function removeSelection(Selection $selection): static
    {
        if ($this->selections->removeElement($selection)) {
            // set the owning side to null (unless already changed)
            if ($selection->getService() === $this) {
                $selection->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addService($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            $article->removeService($this);
        }

        return $this;
    }
}
