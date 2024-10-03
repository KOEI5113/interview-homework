<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface OrderCurrencyInterface
{
    public function initializeOrderCurrencyTrait(): void;
}
