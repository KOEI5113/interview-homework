<?php

namespace Tests\Unit;

use App\Exceptions\OrderCurrencyUnknownException;
use App\Models\Order;
use App\Models\OrderCurrency\OrderJpy;
use App\Models\OrderCurrency\OrderMyr;
use App\Models\OrderCurrency\OrderRmb;
use App\Models\OrderCurrency\OrderTwd;
use App\Models\OrderCurrency\OrderUsd;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected OrderService $OrderService;

    protected const CURRENCY_CODE_LIST = [
        "TWD" => OrderTwd::class,
        "USD" => OrderUsd::class,
        "RMB" => OrderRmb::class,
        "JPY" => OrderJpy::class,
        "MYR" => OrderMyr::class
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->OrderService = app(OrderService::class);
    }

    /**
     * 測試成功創建訂單
     */
    public function test_create_order_successfully()
    {
        foreach (self::CURRENCY_CODE_LIST as $currency => $currencyClass) { 
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'address' => [
                    'city' => 'Taipei',
                    'district' => 'Daan',
                    'street' => '123 Main St',
                ],
                'price' => 1000,
                'currency' => $currency,
            ];

            $order = $this->OrderService->create($data);
            $this->assertInstanceOf(Order::class, $order);
            $this->assertDatabaseHas("orders", ["id" => $order->id]);
            $this->assertDatabaseHas($order->currency->getTable(), ["id" => $order->currency->id]);
        }
    }

    /**
     * 測試創建訂單失敗
     */
    public function test_create_order_fail()
    {
        $this->expectException(OrderCurrencyUnknownException::class);
        $order = $this->OrderService->create([
            'id' => $this->faker->uuid,
            'name' => 'John Doe',
            'address' => [
                'city' => 'Taipei',
                'district' => 'Daan',
                'street' => '123 Main St',
            ],
            'price' => 1000,
            'currency' => "INVALID",
        ]);
        $this->assertDatabaseMissing("orders", ["id" => $order->id]);
    }



    /**
     * 測試成功取得訂單
     */
    public function test_get_successfully()
    {
        foreach (self::CURRENCY_CODE_LIST as $currency => $currencyClass) { 
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'address' => [
                    'city' => 'Taipei',
                    'district' => 'Daan',
                    'street' => '123 Main St',
                ],
                'price' => 1000,
                'currency' => $currency,
            ];

            $order = $this->OrderService->create($data);
            $this->assertInstanceOf(Order::class, $order);
            $this->assertDatabaseHas("orders", ["id" => $order->id]);
            $this->assertDatabaseHas($order->currency->getTable(), ["id" => $order->currency->id]);

            $orderGot = $this->OrderService->get($data["id"]);
            $this->assertEquals($order->toArray(), $orderGot->toArray());
        }
    }

    /**
     * 測試取得訂單失敗
     */
    public function test_get_fail()
    {
        $orderGot = $this->OrderService->get("nonexistent-id");
        $this->assertNull($orderGot);
    }
}