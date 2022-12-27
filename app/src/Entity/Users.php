<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Orders::class, orphanRemoval: true)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'courier', targetEntity: Trips::class)]
    private Collection $trips;

    #[ORM\OneToMany(mappedBy: 'reporter', targetEntity: DelayReports::class)]
    private Collection $delayReports;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->trips = new ArrayCollection();
        $this->delayReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setOwner($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getOwner() === $this) {
                $order->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trips>
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trips $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips->add($trip);
            $trip->setCourier($this);
        }

        return $this;
    }

    public function removeTrip(Trips $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getCourier() === $this) {
                $trip->setCourier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DelayReports>
     */
    public function getDelayReports(): Collection
    {
        return $this->delayReports;
    }

    public function addDelayReport(DelayReports $delayReport): self
    {
        if (!$this->delayReports->contains($delayReport)) {
            $this->delayReports->add($delayReport);
            $delayReport->setReporter($this);
        }

        return $this;
    }

    public function removeDelayReport(DelayReports $delayReport): self
    {
        if ($this->delayReports->removeElement($delayReport)) {
            // set the owning side to null (unless already changed)
            if ($delayReport->getReporter() === $this) {
                $delayReport->setReporter(null);
            }
        }

        return $this;
    }
}
