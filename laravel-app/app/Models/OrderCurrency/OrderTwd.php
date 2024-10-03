<?php

namespace App\Models\OrderCurrency;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTwd extends BasicCurrency
{
    use HasFactory;

    protected $table = "orders_twd";
}
