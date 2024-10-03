<?php

namespace App\Models\OrderCurrency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicCurrency extends Model
{
    use HasFactory;

    protected $fillable = [
        'price'
    ];
}
