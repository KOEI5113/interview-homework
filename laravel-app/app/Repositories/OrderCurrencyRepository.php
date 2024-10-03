<?php

namespace App\Repositories;

use App\Exceptions\OrderCurrencyUnknownException;
use App\Models\OrderJpy;
use App\Models\OrderMyr;
use App\Models\OrderRmb;
use App\Models\OrderTwd;
use App\Models\OrderUsd;
use App\Interfaces\OrderCurrencyInterface;

class OrderCurrencyRepository
{
    private function getOrderCurrencyClass(string $currency): string
    {
        return match (strtolower($currency)) {
            "twd" => OrderTwd::class,
            "usd" => OrderUsd::class,
            "jpy" => OrderJpy::class,
            "rmb" => OrderRmb::class,
            "myr" => OrderMyr::class,
            default => throw OrderCurrencyUnknownException::make("無效的幣別"),
        };
    }

    public function create(string $currency, int $price): OrderCurrencyInterface 
    {
        $orderCurrencyClass = $this->getOrderCurrencyClass($currency);
        return (new $orderCurrencyClass)->create(["price" => $price]);
    }
}
