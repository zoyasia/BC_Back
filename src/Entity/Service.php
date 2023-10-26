<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ApiResource]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Selection::class)]
    private Collection $selections;

    public function __construct()
    {
        $this->selections = new ArrayCollection();
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
}
