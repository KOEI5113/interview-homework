<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Services\OrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreateListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected OrderService $OrderService
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(
        OrderCreateEvent $event
    ): void
    {
        $this->OrderService->create($event->data);
    }
}
