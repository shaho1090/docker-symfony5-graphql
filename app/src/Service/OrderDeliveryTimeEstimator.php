<?php


namespace App\Service;


use App\Entity\Order;

class OrderDeliveryTimeEstimator
{
    public function get(Order $order): ?int
    {
        return ($order->getDeliveryTime() + rand(10,50));
    }
}