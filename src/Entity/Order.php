<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $payment_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $drop_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $pickup_date = null;

    #[ORM\Column]
    private ?float $total_price = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $employee = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $customer = null;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: Selection::class)]
    private Collection $selection;

    public function __construct()
    {
        $this->selection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->payment_date;
    }

    public function setPaymentDate(\DateTimeInterface $payment_date): static
    {
        $this->payment_date = $payment_date;

        return $this;
    }

    public function getDropDate(): ?\DateTimeInterface
    {
        return $this->drop_date;
    }

    public function setDropDate(\DateTimeInterface $drop_date): static
    {
        $this->drop_date = $drop_date;

        return $this;
    }

    public function getPickupDate(): ?\DateTimeInterface
    {
        return $this->pickup_date;
    }

    public function setPickupDate(\DateTimeInterface $pickup_date): static
    {
        $this->pickup_date = $pickup_date;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): static
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, Selection>
     */
    public function getSelection(): Collection
    {
        return $this->selection;
    }

    public function addSelection(Selection $selection): static
    {
        if (!$this->selection->contains($selection)) {
            $this->selection->add($selection);
            $selection->setOrders($this);
        }

        return $this;
    }

    public function removeSelection(Selection $selection): static
    {
        if ($this->selection->removeElement($selection)) {
            // set the owning side to null (unless already changed)
            if ($selection->getOrders() === $this) {
                $selection->setOrders(null);
            }
        }

        return $this;
    }

}
