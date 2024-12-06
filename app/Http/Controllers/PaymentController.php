<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Endpoint para realizar um pagamento.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makePayment(Request $request)
    {
        $data = $request->validate([
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
        ]);

        try {
            $payment = $this->paymentService->makePayment($data);
            return response()->json(['success' => true, 'data' => $payment], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
