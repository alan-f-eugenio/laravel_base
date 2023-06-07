<?php

namespace App\Http\Controllers\Integrations;

use App\Helpers\DefaultStatus;
use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class PagseguroController extends Controller {
    public static function calcShipping($cep, $listShippProducts, $total, $inputs = false) {
        if (config('integrations.frete.frenet')['status'] != DefaultStatus::STATUS_ATIVO) {
            return false;
        }

        $client = new Client;
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'token' => config('integrations.frete.frenet')['defines']['token'],
        ];

        $strProds = '';
        $prazoAdicional = 0;
        foreach ($listShippProducts as $shippProduct) {
            $product = $shippProduct['product'];

            $strProds .= '{
                    "SKU": "' . $product->sku . '",
                    "Height": ' . $product->height . ',
                    "Length": ' . $product->depth . ',
                    "Width": ' . $product->width . ',
                    "Weight": ' . $product->getRawOriginal('weight') . ',
                    "Quantity": ' . $shippProduct['qtd'] . ',
                },';

            $prazoAdicional = ($product->deadline > $prazoAdicional) ? $product->deadline : $prazoAdicional;
        }

        $body = '{
            "SellerCEP": ' . $cep . ',
            "RecipientCEP": ' . preg_replace('/[^0-9]/', '', config('defines')->company_cep) . ',
            "ShipmentInvoiceValue": ' . $total . ',
            "ShippingItemArray": [' . $strProds . '],
            }';

        // dd($body);

        try {
            $guzzle_request = new GuzzleRequest('POST', 'https://api.frenet.com.br/shipping/quote', $headers, $body);
            $res = $client->sendAsync($guzzle_request)->wait();
        } catch (Exception $e) {
            return false;
        }
        $shippings = json_decode($res->getBody());

        $lowestValue = null;
        $shippingListHTML = '';
        if (isset($shippings->ShippingSevicesArray) && isset($shippings->ShippingSevicesArray[0]->ServiceCode)) {
            foreach ($shippings->ShippingSevicesArray as $shipping) {
                if ($shipping->Error !== true) {
                    if (is_null($lowestValue) || $shipping->ShippingPrice < $lowestValue) {
                        $lowestValue = $shipping->ShippingPrice;
                    }
                    $prazoTotal = $shipping->DeliveryTime + $prazoAdicional;
                    $shippingPrice = number_format($shipping->ShippingPrice, 2, ',', '.');
                    $shippingListHTML .= "<li>
                            <p><b>Frenet - {$shipping->ServiceDescription}:</b> R$ {$shippingPrice}<br><small>{$prazoTotal} dia(s)</small></p>
                            </li>";
                }
            }
        }

        return !is_null($lowestValue)
            ? ['html' => $shippingListHTML, 'lowestValue' => $lowestValue]
            : false;
    }
}
