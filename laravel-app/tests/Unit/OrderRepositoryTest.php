<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderCurrency\OrderJpy;
use App\Models\OrderCurrency\OrderMyr;
use App\Models\OrderCurrency\OrderRmb;
use App\Models\OrderCurrency\OrderTwd;
use App\Models\OrderCurrency\OrderUsd;
use App\Repositories\OrderCurrencyRepository;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected const CURRENCY_CODE_LIST = [
        "TWD" => OrderTwd::class,
        "USD" => OrderUsd::class,
        "RMB" => OrderRmb::class,
        "JPY" => OrderJpy::class,
        "MYR" => OrderMyr::class
    ];

    protected OrderRepository $OrderRepository;
    protected OrderCurrencyRepository $OrderCurrencyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->OrderRepository = new OrderRepository();
        $this->OrderCurrencyRepository = new OrderCurrencyRepository();
    }

    /**
     * 測試成功創建訂單
     */
    public function test_create_order_successfully()
    {
        foreach (self::CURRENCY_CODE_LIST as $currency => $class) {
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'city' => 'Taipei',
                'district' => 'Daan',
                'street' => '123 Main St'
            ];
            $OrderCurrency = $this->OrderCurrencyRepository->create($currency, 5000);
            $Order = $this->OrderRepository->create(
                $OrderCurrency, 
                $data["id"],
                $data["name"],
                $data["city"],
                $data["district"],
                $data["street"]
            );

            $this->assertInstanceOf(Order::class, $Order);
            $this->assertDatabaseHas('orders', $data);
            $this->assertEquals($OrderCurrency->id, $Order->currency->id);
        }
    }

    /**
     * 測試創建訂單時的失敗情況（重複的訂單編號）
     */
    public function test_create_order_fails_on_duplicate_id()
    {
        foreach (self::CURRENCY_CODE_LIST as $currency => $class) {
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'city' => 'Taipei',
                'district' => 'Daan',
                'street' => '123 Main St'
            ];
            $OrderCurrency = $this->OrderCurrencyRepository->create($currency, 5000);

            // 首次建立訂單
            $Order = $this->OrderRepository->create(
                $OrderCurrency, 
                $data["id"],
                $data["name"],
                $data["city"],
                $data["district"],
                $data["street"]
            );

            $this->assertInstanceOf(Order::class, $Order);
            $this->assertDatabaseHas('orders', $data);
            $this->assertEquals($OrderCurrency->id, $Order->currency->id);

            // 嘗試創建重複的訂單編號
            $this->expectException(\Illuminate\Database\QueryException::class);

            // 首次建立訂單
            $Order = $this->OrderRepository->create(
                $OrderCurrency, 
                $data["id"],
                $data["name"],
                $data["city"],
                $data["district"],
                $data["street"]
            );
        }
    }

    /**
     * 測試成功取得訂單
     */
    public function test_get_order_successfully()
    {
        foreach (self::CURRENCY_CODE_LIST as $currency => $class) {
            // 先建立訂單
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'city' => 'Taipei',
                'district' => 'Daan',
                'street' => '123 Main St'
            ];
            $OrderCurrency = $this->OrderCurrencyRepository->create($currency, 5000);
            $Order = $this->OrderRepository->create(
                $OrderCurrency, 
                $data["id"],
                $data["name"],
                $data["city"],
                $data["district"],
                $data["street"]
            );

            $this->assertInstanceOf(Order::class, $Order);
            $this->assertDatabaseHas('orders', ["id" => $data["id"]]);
            $this->assertEquals($OrderCurrency->id, $Order->currency->id);

            // 撈取訂單結果並驗證是否雙方相同
            $OrderGot = $this->OrderRepository->get($data["id"]);
            $this->assertInstanceOf(Order::class, $OrderGot);
            $this->assertEquals($Order->id, $OrderGot->id);
        }
    }


    /**
     * 測試成功取得訂單
     */
    public function test_get_fails_on_nonexistent_order()
    {
        foreach (self::CURRENCY_CODE_LIST as $currency => $class) {
            // 撈取不存在的訂單
            $Order = $this->OrderRepository->get($currency);
            $this->assertNull($Order);
        }
    }
}