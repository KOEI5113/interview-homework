<?php

namespace App\Models\OrderCurrency;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderUsd extends BasicCurrency
{
    use HasFactory;

    protected $table = "orders_usd";
}
