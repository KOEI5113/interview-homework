<?php

namespace Tests\Unit;

use App\Events\OrderCreateEvent;
use App\Listeners\OrderCreateListener;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class OrderCreateListenerTest extends TestCase
{
    use RefreshDatabase;

    protected OrderService $OrderService;
    protected OrderCreateListener $Listener;

    protected function setUp(): void
    {
        parent::setUp();
        $this->OrderService = Mockery::mock(OrderService::class);
        $this->Listener = new OrderCreateListener($this->OrderService);
    }

    /**
     * 測試 OrderCreateListener 的 handle 方法
     */
    public function test_handle_calls_order_service_create()
    {
        $data = [
            'id' => 'order123',
            'name' => 'John Doe',
            'address' => [
                'city' => 'Taipei',
                'district' => 'Daan',
                'street' => '123 Main St',
            ],
            'price' => 1000,
            'currency' => 'TWD',
        ];

        $Event = new OrderCreateEvent($data);

        // 設定期望，當 handle 被呼叫時，orderService 的 create 方法應該被呼叫一次
        $this->OrderService
            ->shouldReceive('create')
            ->once()
            ->with($data);

        // 呼叫 handle 方法
        $this->Listener->handle($Event);
    }
}