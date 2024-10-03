<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * OrderCurrencyTrait
 * 
 * 用來給予各個子訂單金流表的訂單使用
 */
trait OrderCurrencyTrait
{
    public function initializeOrderCurrencyTrait(): void
    {
        $this->fillable[] = 'price';
    }
}
