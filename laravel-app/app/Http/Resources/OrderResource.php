<?php

namespace App\Http\Resources;

use App\Exceptions\OrderCurrencyUnknownException;
use App\Models\OrderJpy;
use App\Models\OrderMyr;
use App\Models\OrderRmb;
use App\Models\OrderTwd;
use App\Models\OrderUsd;
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
