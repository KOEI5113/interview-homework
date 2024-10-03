<?php

namespace App\Models\OrderCurrency;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderRmb extends BasicCurrency
{
    use HasFactory;

    protected $table = "orders_rmb";
}
