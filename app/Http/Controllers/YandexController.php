<?php

namespace App\Http\Controllers;

use App\Services\YandexKassaService;
use Illuminate\Http\Request;

class YandexController extends Controller
{
    public function index(Request $request)
    {
        $yandexManager = new YandexKassaService();
        $yandexManager->setAuth();

        $data = [
            'amount' => 10,
            'order_id' => 1,
            'user' => 'test@varka.com',
            'return_url' => 'https://lazy.codes',
            'payment_method' => 'bank_card',
        ];

        $result = $yandexManager->createPayment($data);

        return response()->json($result);
    }
}
