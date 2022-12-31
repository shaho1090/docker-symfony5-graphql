<?php


namespace App\Service\Factory;


use App\Entity\DelayedOrder;
use App\Entity\DelayReport;
use App\Entity\Order;
use App\Entity\TripState;
use App\Repository\OrderRepository;
use App\Service\OrderDeliveryTimeEstimator;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class DelayReportFactoryService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private OrderRepository $orderRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create($delayReportDetails): DelayReport|string|null
    {
        $now = Carbon::now();

        $order = $this->orderRepository->find($delayReportDetails['orderId']);

        $this->checkOrderDeliveryTime($order);

        $delayReport = new DelayReport();
        $delayReport->setOrder($order);
        $delayReport->setDescription($delayReportDetails['description']);
        $delayReport->setCreatedAt($now);
        $delayReport->setUpdatedAt($now);
        $delayReport->setVendor($order->getVendor());
        $delayReport->setReporter($order->getCustomer());

        $this->manager->persist($delayReport);
        $this->manager->flush();

        if($order->shouldBeInDelayedQueue()){
            $this->addToDelayedQueue($order,$delayReport);
        }

        return $delayReport;
    }

    /**
     * @throws Exception
     */
    private function checkOrderDeliveryTime($order)
    {
        if (!$order->deliveryTimePassed()) {
            throw new Exception(
                "You can set delay report after delivery time!",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function addToDelayedQueue(Order $order,DelayReport $delayReport)
    {
        $now = Carbon::now();
        $delayedOrder = new DelayedOrderQueue();
        $delayedOrder->setCreatedAt($now);
        $delayedOrder->setOrder($order);
        $delayedOrder->setState(DelayedOrderQueue::STATE_PENDING);
        $delayedOrder->setDelayReport($delayReport);

        $this->manager->persist($delayedOrder);
        $this->manager->flush();
    }
}