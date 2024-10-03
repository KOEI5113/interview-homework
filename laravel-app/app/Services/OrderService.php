<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderCurrencyRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected OrderRepository $OrderRepository,
        protected OrderCurrencyRepository $OrderCurrencyRepository
    ) 
    {
    }

    public function create(array $data): Order
    {
        DB::beginTransaction();
        try {
            $OrderCurrency = $this->OrderCurrencyRepository->create($data["currency"], $data["price"]);
            $Order = $this->OrderRepository->create(
                $OrderCurrency,
                $data["id"],
                $data["name"],
                $data["address"]["city"],
                $data["address"]["district"],
                $data["address"]["street"]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $Order;
    }

    public function get(string $id): ?Order
    {
        return $this->OrderRepository->get($id);
    }
}
