<?php
namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function createOrder($data)
    {
        return Order::create([
            "customer_name" => $data["customer_name"],
            "destination" => $data["destination"],
            "packages" => $data["packages"]
        ]);
    }
}
