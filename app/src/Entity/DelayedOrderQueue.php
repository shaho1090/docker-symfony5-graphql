<?php

namespace App\Entity;

use App\Repository\DelayedOrderQueueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelayedOrderQueueRepository::class)]
class DelayedOrderQueue
{
    const STATE_PENDING = "pending";
    const STATE_CHECKING = "checking";
    const STATE_CHECKED = "checked";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'delayedOrderQueues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $request = null;

    #[ORM\OneToOne(inversedBy: 'delayedOrderQueue', cascade: ['persist', 'remove'])]
    private ?DelayReport $delayReport = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\ManyToOne(inversedBy: 'delayedOrderQueues')]
    private ?User $agent = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->request;
    }

    public function setOrder(?Order $order): self
    {
        $this->request = $order;

        return $this;
    }

    public function getDelayReport(): ?DelayReport
    {
        return $this->delayReport;
    }

    public function setDelayReport(?DelayReport $delayReport): self
    {
        $this->delayReport = $delayReport;

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

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
