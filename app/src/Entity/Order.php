<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $delivery_time = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vendor $vendor = null;

    #[ORM\OneToOne(mappedBy: 'request', cascade: ['persist', 'remove'])]
    private ?Trip $trips = null;

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

    public function getDeliveryTime(): ?int
    {
        return $this->delivery_time;
    }

    public function setDeliveryTime(int $delivery_time): self
    {
        $this->delivery_time = $delivery_time;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

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

    public function getTrips(): ?Trip
    {
        return $this->trips;
    }

    public function setTrips(Trip $trips): self
    {
        // set the owning side of the relation if necessary
        if ($trips->getRequest() !== $this) {
            $trips->setRequest($this);
        }

        $this->trips = $trips;

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
