<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use App\Service\OrderDeliveryTimeEstimator;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
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

    #[ORM\Column]
    private ?\DateTime $created_at = null;

    #[ORM\Column]
    private ?\DateTime $updated_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true)]
    private ?\DateTimeInterface $be_delivered_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $delivery_address = null;

    #[ORM\Column()]
    private ?int $delay_time = 0;

    private ?int $new_delivery_time_estimation = null;

    #[ORM\OneToMany(mappedBy: 'request', targetEntity: DelayedOrderQueue::class, orphanRemoval: true)]
    private Collection $delayedOrderQueues;

    public function __construct()
    {
        $this->delayReports = new ArrayCollection();
        $this->delayedOrderQueues = new ArrayCollection();
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
        if ($trip->getOrder() !== $this) {
            $trip->setOrder($this);
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
            $delayReport->setOrder($this);
        }

        return $this;
    }

    public function removeDelayReport(DelayReport $delayReport): self
    {
        if ($this->delayReports->removeElement($delayReport)) {
            // set the owning side to null (unless already changed)
            if ($delayReport->getOrder() === $this) {
                $delayReport->setOrder(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null;
    }

    public function setUpdatedAt(\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getBeDeliveredAt(): ?string
    {
        return $this->be_delivered_at ? $this->be_delivered_at->format('Y-m-d H:i:s') : null;
    }

    public function setBeDeliveredAt(\DateTimeInterface $be_delivered_at): self
    {
        $this->be_delivered_at = $be_delivered_at;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->delivery_address;
    }

    public function setDeliveryAddress(?string $delivery_address): self
    {
        $this->delivery_address = $delivery_address;

        return $this;
    }

    public function getDelayTime(): ?int
    {
        return $this->delay_time;
    }

    public function setDelayTime(int $delay_time): self
    {
        $this->delay_time = $delay_time;

        return $this;
    }

    public function deliveryTimePassed(): bool
    {
        return Carbon::parse($this->be_delivered_at)->isBefore(Carbon::now());
    }

    public function setNewDeliveryTimeEstimation(): void
    {
        $orderTrip = $this->getTrip();

        if(!is_null($orderTrip) && in_array($orderTrip->getCurrentState(),TripState::getInProgressStates()) ){
            $this->new_delivery_time_estimation = (new OrderDeliveryTimeEstimator())->get($this);
            return;
        }

        $this->new_delivery_time_estimation = $this->delivery_time;
    }

    public function getNewDeliveryTimeEstimation(): ?int
    {
        if(is_null($this->new_delivery_time_estimation)){
            $this->setNewDeliveryTimeEstimation();
        }

        return $this->new_delivery_time_estimation;
    }

    public function shouldBeInDelayedQueue(): bool
    {
        $orderTrip = $this->getTrip();

        if(is_null($orderTrip)){
            return true;
        }

        if(!in_array($orderTrip->getCurrentState(),TripState::getInProgressStates())){
            return true;
        }

        return false;
    }

    /**
     * @return Collection<int, DelayedOrderQueue>
     */
    public function getDelayedOrderQueues(): Collection
    {
        return $this->delayedOrderQueues;
    }

    public function addDelayedOrderQueue(DelayedOrderQueue $delayedOrderQueue): self
    {
        if (!$this->delayedOrderQueues->contains($delayedOrderQueue)) {
            $this->delayedOrderQueues->add($delayedOrderQueue);
            $delayedOrderQueue->setOrder($this);
        }

        return $this;
    }

    public function removeDelayedOrderQueue(DelayedOrderQueue $delayedOrderQueue): self
    {
        if ($this->delayedOrderQueues->removeElement($delayedOrderQueue)) {
            // set the owning side to null (unless already changed)
            if ($delayedOrderQueue->getOrder() === $this) {
                $delayedOrderQueue->setOrder(null);
            }
        }

        return $this;
    }
}
