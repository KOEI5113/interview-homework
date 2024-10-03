<?php

namespace App\Repositories;

use App\Interfaces\OrderCurrencyInterface;
use App\Models\Order;

class OrderRepository
{
    public function create(
        OrderCurrencyInterface $OrderCurrency,
        string $order_number,
        string $name,
        string $city,
        string $district,
        string $street
    ): Order
    {
        $Order = Order::make([
            "order_number"  => $order_number,
            "name"          => $name,
            "city"          => $city,
            "district"      => $district,
            "street"        => $street
        ]);
        $Order->currency()->associate($OrderCurrency);
        $Order->save();
        return $Order;
    }

    public function getByOrderNumber(string $orderNumber): ?Order
    {
        return Order::with("currency")->where("order_number", $orderNumber)->first();
    }
}
