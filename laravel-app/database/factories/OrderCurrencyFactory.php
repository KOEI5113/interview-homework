<?php

namespace Database\Factories;

use App\Exceptions\OrderCurrencyUnknownException;
use App\Models\OrderCurrency\OrderJpy;
use App\Models\OrderCurrency\OrderMyr;
use App\Models\OrderCurrency\OrderRmb;
use App\Models\OrderCurrency\OrderTwd;
use App\Models\OrderCurrency\OrderUsd;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderCurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "price" => $this->faker->numberBetween(3000, 8000)
        ];
    }

    public function setCurrency(string $currency): self
    {
        $this->model = match (strtolower($currency)) {
            "twd" => new OrderTwd,
            "usd" => new OrderUsd,
            "jpy" => new OrderJpy,
            "rmb" => new OrderRmb,
            "myr" => new OrderMyr,
            default => throw OrderCurrencyUnknownException::make("無效的幣別"),
        };
        return $this;
    }
}
