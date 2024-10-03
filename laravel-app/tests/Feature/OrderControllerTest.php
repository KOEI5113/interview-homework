<?php

namespace Tests\Feature;

use App\Events\OrderCreateEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\OrderCurrency\OrderJpy;
use App\Models\OrderCurrency\OrderMyr;
use App\Models\OrderCurrency\OrderRmb;
use App\Models\OrderCurrency\OrderTwd;
use App\Models\OrderCurrency\OrderUsd;
use App\Services\OrderService;
use Illuminate\Support\Facades\Event;

class OrderControllerTest extends TestCase
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

    protected OrderService $OrderService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->OrderService = app(OrderService::class);
    }

    /**
     * 測試成功創建訂單
     */
    public function test_store_creates_order_successfully()
    {
        foreach (self::CURRENCY_CODE_LIST as $code => $class) {
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'address' => [
                    'city' => 'Taipei',
                    'district' => 'Daan',
                    'street' => '123 Main St',
                ],
                'price' => 1000,
                'currency' => $code,
            ];
    
            $response = $this->postJson('/api/order', $data);
            $response->assertStatus(Response::HTTP_OK);
            $this->assertDatabaseHas('orders', ['id' => $data["id"]]);
        };
    }

    /**
     * 測試創建訂單時的失敗情況（無效的幣別）
     */
    public function test_store_fails_on_invalid_currency()
    {
        $data = [
            'id' => $this->faker->uuid,
            'name' => 'John Doe',
            'address' => [
                'city' => 'Taipei',
                'district' => 'Daan',
                'street' => '123 Main St',
            ],
            'price' => 1000,
            'currency' => "UNKNOWN",
        ];
        
        $response = $this->postJson('/api/order', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(['message' => 'The selected currency is invalid.']);
        $this->assertDatabaseMissing("orders", ["id" => $data["id"]]);
    }

    /**
     * 測試創建訂單時的失敗情況（重複的訂單編號）
     */
    public function test_store_fails_on_duplicate_order_id()
    {
        Event::fake();
        foreach (self::CURRENCY_CODE_LIST as $code => $class) {
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'address' => [
                    'city' => 'Taipei',
                    'district' => 'Daan',
                    'street' => '123 Main St',
                ],
                'price' => 1000,
                'currency' => $code,
            ];

            $this->OrderService->create($data);
            $response = $this->postJson('/api/order', $data);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson(value: ['message' => 'The id has already been taken.']);
            Event::assertNotDispatched(OrderCreateEvent::class);
        };
    }

    /**
     * 測試成功查詢訂單
     */
    public function test_show_returns_order_successfully()
    {
        foreach (self::CURRENCY_CODE_LIST as $code => $class) {
            $data = [
                'id' => $this->faker->uuid,
                'name' => 'John Doe',
                'address' => [
                    'city' => 'Taipei',
                    'district' => 'Daan',
                    'street' => '123 Main St',
                ],
                'price' => 1000,
                'currency' => $code,
            ];
            $Order = $this->OrderService->create($data);
            $response = $this->getJson('/api/order/' . $Order->id);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJson(['id' => $data["id"]]);
            $this->assertDatabaseHas("orders", ['id' => $data["id"]]);
        };
    }

    /**
     * 測試查詢不存在的訂單
     */
    public function test_show_fails_on_nonexistent_order()
    {
        $missedId = "nonexistent-id";
        $response = $this->getJson('/api/order/' . $missedId);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(['message' => 'The selected order is invalid.']);
        $this->assertDatabaseMissing("orders", ["id" => $missedId]);
    }
}
