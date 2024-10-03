<?php

namespace App\Models\OrderCurrency;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderJpy extends BasicCurrency
{
    use HasFactory;

    protected $table = "orders_jpy";
}
