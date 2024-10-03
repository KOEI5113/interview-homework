<?php

namespace App\Models;

use App\Interfaces\OrderCurrencyInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\OrderCurrencyTrait;

class OrderTwd extends Model implements OrderCurrencyInterface
{
    use HasFactory;
    use OrderCurrencyTrait;

    protected $table = "orders_twd";
}
