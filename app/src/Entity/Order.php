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

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $customer = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vendor $vendor = null;

    #[ORM\Column]
    private ?int $delivery_time = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'request', cascade: ['persist', 'remove'])]
    private ?Trip $trip = null;

    #[ORM\OneToMany(mappedBy: 'request', targetEntity: DelayReport::class, orphanRemoval: true)]
    private Collection $delayReports;

    public function __construct()
    {
        $this->delayReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getDeliveryTime(): ?int
    {
        return $this->delivery_time;
    }

    public function setDeliveryTime(int $delivery_time): self
    {
        $this->delivery_time = $delivery_time;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(Trip $trip): self
    {
        // set the owning side of the relation if necessary
        if ($trip->getRequest() !== $this) {
            $trip->setRequest($this);
        }

        $this->trip = $trip;

        return $this;
    }

    /**
     * @return Collection<int, DelayReport>
     */
    public function getDelayReports(): Collection
    {
        return $this->delayReports;
    }

    public function addDelayReport(DelayReport $delayReport): self
    {
        if (!$this->delayReports->contains($delayReport)) {
            $this->delayReports->add($delayReport);
            $delayReport->setRequest($this);
        }

        return $this;
    }

    public function removeDelayReport(DelayReport $delayReport): self
    {
        if ($this->delayReports->removeElement($delayReport)) {
            // set the owning side to null (unless already changed)
            if ($delayReport->getRequest() === $this) {
                $delayReport->setRequest(null);
            }
        }

        return $this;
    }
}