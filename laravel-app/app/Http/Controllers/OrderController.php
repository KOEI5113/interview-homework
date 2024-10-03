<?php

namespace App\Http\Controllers;

use App\Events\OrderCreateEvent;
use App\Http\Requests\ShowOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $StoreOrderRequest): JsonResponse
    {
        OrderCreateEvent::dispatch($StoreOrderRequest->validated());
        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(
        ShowOrderRequest $ShowOrderRequest,
        OrderService $OrderService
    ): JsonResponse
    {
        return response()->json(new OrderResource($OrderService->get($ShowOrderRequest->validated()["order"])));
    }
}
