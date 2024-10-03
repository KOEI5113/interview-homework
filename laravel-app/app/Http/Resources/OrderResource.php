<?php

namespace App\Http\Resources;

use App\Exceptions\OrderCurrencyUnknownException;
use App\Models\OrderCurrency\OrderJpy;
use App\Models\OrderCurrency\OrderMyr;
use App\Models\OrderCurrency\OrderRmb;
use App\Models\OrderCurrency\OrderTwd;
use App\Models\OrderCurrency\OrderUsd;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "address" => [
                "city" => $this->city,
                "district" => $this->district,
                "street" => $this->street
            ],
            "price" => $this->currency->price,
            "currency" => match (get_class($this->currency)) {
                OrderTwd::class => "twd",
                OrderUsd::class => "usd",
                OrderJpy::class => "jpy",
                OrderRmb::class => "rmb",
                OrderMyr::class => "myr",
                default => new OrderCurrencyUnknownException,
            }
        ];
    }
}
