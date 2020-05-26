<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Collection;
use YandexCheckout\Client;

class YandexKassaService
{
    private $shopId = null;

    private $key = null;

    private $client = null;

    public function __construct()
    {
        $this->shopId = config('yandex.YANDEX_KASSA_SHOP_ID');
        $this->key = config('yandex.YANDEX_KASSA_KEY');
    }

    public function setAuth()
    {
        $this->client = new Client();
        $this->client->setAuth($this->shopId, $this->key);
    }

    public function createPayment(array $data)
    {
        $paymentRequest = [
            'amount' => [
                'value' => $data['amount'],
                'currency' => 'RUB',
            ],
            'description' => "Оплата заказа №".$data['order_id']." для ".$data['user'],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $data['return_url'],
            ],
            'payment_method_data' => [
                'type' => $data['payment_method'] // bank_card, yandex_money
            ],
            'capture' => true,
        ];
        $idempotenceKey = uniqid('', true);

        $response = $this->client->createPayment($paymentRequest, $idempotenceKey);

        return $response;
    }

    public function convertItems(array $products)
    {
        $items = [];
        foreach ($products as $product) {
            $price = '0.00';
            $pointPosition = mb_strpos(strval($product['price']), '.');
            if ($pointPosition) {
                if (strlen(strval($product['price'])) - $pointPosition > 3) {
                    $price = mb_substr(strval($product['price']), 0, $pointPosition + 3);
                } else if (strlen(strval($product['price'])) - $pointPosition < 3) {
                    $price = strval($product['price']);
                    for ($i = 0; $i < 3 - (strlen(strval($product['price'])) - $pointPosition); $i++) {
                        $price .= "0";
                    }
                } else {
                    $price = strval($product['price']);
                }
            } else {
                $price = strval($product['price']).".00";
            }

            $items[] = [
                'description' => $product['name'],
                'quantity' => $product['amount'],
                'amount' => [
                    'value' => $price,
                    'currency' => "RUB",
                ],
                'vat_code' => '1'
            ];
        }

        return $items;
    }

    public function getPaymentInfo(string $paymentId)
    {
        $payment = $this->client->getPaymentInfo($paymentId);

        return $payment;
    }

    public function submitPayment(string $paymentId)
    {
        $idempotenceKey = uniqid('', true);
        $payment = $this->getPaymentInfo($paymentId);

        $response = $this->client->capturePayment(
            [
                'amount' => [
                    'value' => $payment->amount->value,
                    'currency' => 'RUB',
                ],
            ],
            $paymentId,
            $idempotenceKey
        );

        return $response;
    }

    public function cancelPayment(string $paymentId)
    {
        $idempotenceKey = uniqid('', true);

        $response = $this->client->cancelPayment(
            $paymentId,
            $idempotenceKey
        );

        return $response;
    }

    public function createPaymentReceipt(string $paymentId, array $data)
    {
        $idempotenceKey = uniqid('', true);
        $payment = $this->getPaymentInfo($paymentId);

        $response = $this->client->createReceipt(
            [
                'customer' => [
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ],
                'payment_id' => $paymentId,
                'type' => 'payment',
                'send' => true,
                'items' => $data['items'],
                'settlements' => [
                    [
                        'type' => $data['settlement_type'], // cashless, prepayment
                        'amount' => [
                            'value' => $payment->amount->value,
                            'currency' => 'RUB',
                        ]
                    ],
                ],
                'phone' => $data['phone'],
                'email' => $data['email'],
            ],
            $idempotenceKey
        );

        return $response;
    }
}
