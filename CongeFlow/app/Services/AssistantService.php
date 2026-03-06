<?php

namespace App\Services;

use GuzzleHttp\Client;

class AssistantService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function ask($question)
    {

        $prompt = "
Tu es un assistant pour une société de logistique.

Si l'utilisateur veut créer une commande,
répond uniquement en JSON :

{
  \"action\":\"create_order\",
  \"customer_name\":\"...\",
  \"destination\":\"...\",
  \"packages\":1
}

Sinon répond normalement.

Question :
$question
";

        $response = $this->client->post(
            "http://localhost:11434/api/generate",
            [
                "json" => [
                    "model" => "llama3",
                    "prompt" => $prompt,
                    "stream" => false
                ]
            ]
        );

        $body = json_decode($response->getBody(), true);

        return $body["response"];
    }
}
