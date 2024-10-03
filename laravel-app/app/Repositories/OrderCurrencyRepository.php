<?php

namespace App\Repositories;

use App\Factories\OrderCurrencyFactory;
use App\Models\OrderCurrency\BasicCurrency;

class OrderCurrencyRepository
{
    public function create(string $currency, int $price): BasicCurrency 
    {
        $Model = OrderCurrencyFactory::create($currency);
        return $Model->create(["price" => $price]);
    }
}
