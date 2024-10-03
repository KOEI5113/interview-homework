<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "city",
        "district", 
        "street",
        "currency_type",
        "currency_id"
    ];

    protected $casts = [
        "id"=> "string"
    ];

    public function currency(): MorphTo
    {
        return $this->morphTo();
    }
}
