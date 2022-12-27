<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ccourier = null;

    #[ORM\OneToOne(inversedBy: 'trip', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $request = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCcourier(): ?User
    {
        return $this->ccourier;
    }

    public function setCcourier(?User $ccourier): self
    {
        $this->ccourier = $ccourier;

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
