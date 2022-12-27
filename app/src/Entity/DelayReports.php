<?php

namespace App\Entity;

use App\Repository\DelayReportsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelayReportsRepository::class)]
class DelayReports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'delayReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $reporter = null;

    #[ORM\ManyToOne(inversedBy: 'delayReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $request = null;

    #[ORM\ManyToOne]
    private ?Users $agent = null;

    #[ORM\Column]
    private ?int $vendor_id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReporter(): ?Users
    {
        return $this->reporter;
    }

    public function setReporter(?Users $reporter): self
    {
        $this->reporter = $reporter;

        return $this;
    }

    public function getRequest(): ?Orders
    {
        return $this->request;
    }

    public function setRequest(?Orders $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getAgent(): ?Users
    {
        return $this->agent;
    }

    public function setAgent(?Users $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getVendorId(): ?int
    {
        return $this->vendor_id;
    }

    public function setVendorId(int $vendor_id): self
    {
        $this->vendor_id = $vendor_id;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
}
