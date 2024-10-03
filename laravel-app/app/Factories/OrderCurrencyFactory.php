<?php
namespace App\Factories;

use App\Exceptions\OrderCurrencyUnknownException;
use App\Models\OrderCurrency\BasicCurrency;
use App\Models\OrderCurrency\OrderJpy;
use App\Models\OrderCurrency\OrderMyr;
use App\Models\OrderCurrency\OrderRmb;
use App\Models\OrderCurrency\OrderTwd;
use App\Models\OrderCurrency\OrderUsd;

/**
 * 工廠模式，根據幣別建立 Eloquent Model
 */
class OrderCurrencyFactory
{
    public static function create(string $currency): BasicCurrency
    {
        return match (strtolower($currency)) {
            "twd" => new OrderTwd,
            "usd" => new OrderUsd,
            "jpy" => new OrderJpy,
            "rmb" => new OrderRmb,
            "myr" => new OrderMyr,
            default => throw OrderCurrencyUnknownException::make("無效的幣別"),
        };
    }
}
