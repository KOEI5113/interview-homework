<?php

namespace App\Repositories;

use App\Interfaces\OrderCurrencyInterface;
use App\Models\Order;

class OrderRepository
{
    public function create(
        OrderCurrencyInterface $OrderCurrency,
        string $id,
        string $name,
        string $city,
        string $district,
        string $street
    ): Order
    {
        $Order = Order::make([
            "id"            => $id,
            "name"          => $name,
            "city"          => $city,
            "district"      => $district,
            "street"        => $street
        ]);
        $Order->currency()->associate($OrderCurrency);
        $Order->save();
        return $Order;
    }

    public function get(string $id): ?Order
    {
        return Order::with("currency")->find($id);
    }
}
