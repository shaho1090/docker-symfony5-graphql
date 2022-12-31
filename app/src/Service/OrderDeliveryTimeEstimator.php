<?php


namespace App\Service;


use App\Entity\Order;

/*
 * for mocking new delivery time estimation
 */
class OrderDeliveryTimeEstimator
{
    public function get(Order $order): ?int
    {
        return ($order->getDeliveryTime() + rand(10,50));
    }
}