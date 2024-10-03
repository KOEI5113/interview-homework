<?php

namespace Tests\Unit;

use App\Events\OrderCreateEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCreateEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 測試 OrderCreateEvent 的實例創建
     */
    public function test_order_create_event_instance()
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

        $this->assertInstanceOf(OrderCreateEvent::class, actual: $Event);
        $this->assertEquals($data, $Event->data);
    }

    /**
     * 測試 OrderCreateEvent 的廣播通道
     */
    public function test_order_create_event_broadcast_on()
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
        $Channels = $Event->broadcastOn();

        $this->assertCount(1, $Channels);
        $this->assertInstanceOf(\Illuminate\Broadcasting\PrivateChannel::class, $Channels[0]);
        $this->assertEquals('private-channel-name', $Channels[0]->name);
    }
}