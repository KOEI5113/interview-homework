<?php

namespace App\Models\OrderCurrency;

use Database\Factories\OrderCurrencyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicCurrency extends Model
{
    use HasFactory;

    protected $fillable = [
        'price'
    ];

    protected static function newFactory()
    {
        return OrderCurrencyFactory::new();
    }
}
