<?php

namespace Modules\Frenet\Http\Controllers;

use App\Helpers\DefaultStatus;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
// use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FrenetController extends Controller {
    public static function calcShipping($cep, $listShippProducts, $total, $inputs = false, $shippingCode = false) {
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
            ' . ($shippingCode ? '"ShippingServiceCode": "' . $shippingCode . '", ' : '') . '
            "ShippingItemArray": [' . $strProds . '],
            }';

        // dd($body);

        try {
            $guzzle_request = new Request('POST', 'https://api.frenet.com.br/shipping/quote', $headers, $body);
            $res = $client->sendAsync($guzzle_request)->wait();
        } catch (Exception $e) {
            return false;
        }
        $shippings = json_decode($res->getBody());
        // dd($shippings);

        $lowestValue = null;
        $shippingListHTML = '';
        $shippingName = '';

        if (isset($shippings->ShippingSevicesArray) && isset($shippings->ShippingSevicesArray[0]->ServiceCode)) {
            foreach ($shippings->ShippingSevicesArray as $shipping) {
                if ($shipping->Error === false) {
                    if (is_null($lowestValue) || $shipping->ShippingPrice < $lowestValue) {
                        $lowestValue = $shipping->ShippingPrice;
                        if ($shippingCode && $shippingCode == $shipping->ServiceCode) {
                            $shippingName = $shipping->ServiceDescription;
                            break;
                        }
                    }
                    $prazoTotal = $shipping->DeliveryTime + $prazoAdicional;
                    $shippingPrice = number_format($shipping->ShippingPrice, 2, ',', '.');
                    if (!$inputs) {
                        $shippingListHTML .= "<li>
                        <p><b>Frenet - {$shipping->ServiceDescription}:</b> R$ {$shippingPrice}<br><small>{$prazoTotal} dia(s)</small></p>
                        </li>";
                    } else {
                        $shippingListHTML .= "<li>
                        <input id='frenet__{$shipping->ServiceCode}' value='frenet__{$shipping->ServiceCode}' data-price='{$shippingPrice}' type='radio' name='shipping' class='peer' required />
                        <label for='frenet__{$shipping->ServiceCode}' class='peer-checked:border-blue-600 peer-checked:text-blue-600'>
                        <b>Frenet - {$shipping->ServiceDescription}:</b> R$ {$shippingPrice}<br><small>{$prazoTotal} dia(s)</small>
                        </label>
                        </li>";
                    }
                }
            }
        }

        if ($shippingCode) {
            return ['name' => $shippingName, 'value' => $lowestValue];
        } else {
            return !is_null($lowestValue)
                ? ['html' => $shippingListHTML, 'lowestValue' => $lowestValue]
                : false;
        }
    }
}
