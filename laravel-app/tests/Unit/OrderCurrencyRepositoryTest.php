<?php

namespace Tests\Unit;

use App\Exceptions\OrderCurrencyUnknownException;
use App\Models\OrderCurrency\OrderJpy;
use App\Models\OrderCurrency\OrderMyr;
use App\Models\OrderCurrency\OrderRmb;
use App\Models\OrderCurrency\OrderTwd;
use App\Models\OrderCurrency\OrderUsd;
use App\Repositories\OrderCurrencyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCurrencyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected const CURRENCY_CODE_LIST = [
        "TWD" => OrderTwd::class,
        "USD" => OrderUsd::class,
        "RMB" => OrderRmb::class,
        "JPY" => OrderJpy::class,
        "MYR" => OrderMyr::class
    ];

    protected OrderCurrencyRepository $OrderCurrencyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->OrderCurrencyRepository = new OrderCurrencyRepository();
    }

    /**
     * 測試成功創建不同幣別的訂單金流
     */
    public function test_create_currency()
    {
        foreach (self::CURRENCY_CODE_LIST as $currency => $class) {
            $price = 5000;
            $OrderCurrency = $this->OrderCurrencyRepository->create($currency, $price);
            $this->assertInstanceOf($class, $OrderCurrency);
            $this->assertDatabaseHas($OrderCurrency->getTable(), ['id' => $OrderCurrency->id]);
        }
    }

    /**
     * 測試創建無效幣別時的異常
     */
    public function test_create_invalid_currency()
    {
        $this->expectException(OrderCurrencyUnknownException::class);
        $this->OrderCurrencyRepository->create('INVALID', 1000);
    }
}