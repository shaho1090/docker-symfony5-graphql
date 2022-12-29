<?php

namespace App\Entity;

use App\Repository\DelayReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelayReportRepository::class)]
class DelayReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'delayReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reporter = null;

    #[ORM\ManyToOne(inversedBy: 'delayReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $request = null;

    #[ORM\Column(nullable: true)]
    private ?int $vendor_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'delayReports')]
    private ?Vendor $vendor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $viewed_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReporter(): ?User
    {
        return $this->reporter;
    }

    public function setReporter(?User $reporter): self
    {
        $this->reporter = $reporter;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->request;
    }

    public function setOrder(?Order $request): self
    {
        $this->request = $request;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getViewedAt(): ?\DateTimeInterface
    {
        return $this->viewed_at;
    }

    public function setViewedAt(?\DateTimeInterface $viewed_at): self
    {
        $this->viewed_at = $viewed_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
