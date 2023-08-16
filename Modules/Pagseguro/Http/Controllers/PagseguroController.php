<?php

namespace Modules\Pagseguro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;
use laravel\pagseguro\Shipping\ShippingInterface as PagSeguroShipping;
use Modules\Cart\Entities\Cart;
use Modules\Customer\Entities\Customer;
use Modules\Order\Entities\Order;

class PagseguroController extends Controller {
    public static function pagseguroPay(Order $order, Cart $cart, Customer $customer) {
        $items = [];

        foreach ($cart->cartProducts as $cartProduct) {
            $product = $cartProduct->product;
            $items[] = [
                'id' => $product->sku,
                'description' => $product->name,
                'quantity' => $cartProduct->qtd,
                'amount' => (float) $product->getRawOriginal('price'),
            ];
        }

        $dataPagseguro = [
            'items' => $items,
            'shipping' => [
                'address' => [
                    'postalCode' => $order->cep,
                    'street' => $order->street,
                    'number' => $order->number,
                    'district' => $order->neighborhood,
                    'city' => $order->city,
                    'state' => $order->state,
                    'complement' => $order->complement,
                    'country' => 'BRA',
                ],
                'type' => PagSeguroShipping::TYPE_UNKNOW,
                'cost' => $order->shipping_value,
            ],
            'sender' => [
                'email' => $customer->email,
                'name' => $customer->fullname,
                'documents' => [
                    [
                        'number' => $customer->person->fisica() ? $customer->cpf : $customer->cnpj,
                        'type' => $customer->person->fisica() ? 'CPF' : 'CNPJ'
                    ]
                ],
                'phone' => [
                    'number' => substr(preg_replace('/[^0-9]/', '', $customer->phone), 2),
                    'areaCode' => substr(preg_replace('/[^0-9]/', '', $customer->phone), 0, 2),
                ],
                'bornDate' => $customer->date_birth,
            ],
            'extraAmount' => $order->discount ? - ($order->discount) : 0,
            'notificationURL' => url('/') . '/paymentNotification/pagseguro',
            'redirectURL' => url('/'),
            'reference' => $order->id
        ];

        $checkout = PagSeguro::checkout()->createFromArray($dataPagseguro);
        $credentials = PagSeguro::credentials()->create(
            config('integrations.pagamento.pagseguro.defines.token'),
            config('integrations.pagamento.pagseguro.defines.email')
        );
        try {
            $information = $checkout->send($credentials);
            // Retorna um objeto de laravel\pagseguro\Checkout\Information\Information
            // dump($information);
            $order->update([
                'payment_link' => $information->getLink(),
                'payment_code' => $information->getCode(),
            ]);
            header('Location: ' . $information->getLink());
            exit;
        } catch (\Exception $e) {
            dd($e);
        }
        // exit;
    }
}
