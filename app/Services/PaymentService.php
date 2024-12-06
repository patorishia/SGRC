<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.gesfaturacao.base_url');
        $this->token = config('services.gesfaturacao.token');
    }

    /**
     * Realizar um pagamento.
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function makePayment(array $data)
    {
        $response = Http::withToken($this->token)
            ->post("{$this->baseUrl}/pagamentos", $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao realizar o pagamento: ' . $response->body());
    }
}
