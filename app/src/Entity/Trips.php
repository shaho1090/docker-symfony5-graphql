<?php

namespace App\Entity;

use App\Repository\TripsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripsRepository::class)]
class Trips
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $courier = null;

    #[ORM\OneToOne(inversedBy: 'trips', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $request = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?Users
    {
        return $this->courier;
    }

    public function setCourier(?Users $courier): self
    {
        $this->courier = $courier;

        return $this;
    }

    public function getRequest(): ?Orders
    {
        return $this->request;
    }

    public function setRequest(Orders $request): self
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
