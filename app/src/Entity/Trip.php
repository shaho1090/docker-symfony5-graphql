<?php

namespace App\Entity;

use App\Repository\TripsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripsRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $courier = null;

    #[ORM\OneToOne(inversedBy: 'trips', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $request = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?User
    {
        return $this->courier;
    }

    public function setCourier(?User $courier): self
    {
        $this->courier = $courier;

        return $this;
    }

    public function getRequest(): ?Order
    {
        return $this->request;
    }

    public function setRequest(Order $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
