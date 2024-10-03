<?php

namespace App\Models\OrderCurrency;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderMyr extends BasicCurrency
{
    use HasFactory;

    protected $table = "orders_myr";
}
