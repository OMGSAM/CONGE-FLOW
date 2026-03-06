<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OllamaService;
use App\Services\OrderService;
use App\Services\AssistantService;


class AssistantController extends Controller
{
    protected $ollama;

    public function __construct(OllamaService $ollama)
    {
        $this->ollama = $ollama;
    }
  
public function chat(Request $request,
                     AssistantService $ai,
                     OrderService $orders)
{

    $response = $ai->ask($request->question);

    $data = json_decode($response, true);

    if(isset($data["action"]) && $data["action"] == "create_order")
    {

        $order = $orders->createOrder($data);

        return response()->json([
            "message" => "Commande créée",
            "order" => $order
        ]);
    }

    return response()->json([
        "answer" => $response
    ]);
}

}
