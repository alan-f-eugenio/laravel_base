<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Integrations\CorreioController;
use App\Http\Controllers\Integrations\FrenetController;
use App\Models\Product;
use Illuminate\Http\Request;

class ShippingController extends Controller {
    public function __invoke(Request $request) {
        $cep = preg_replace('/[^0-9]/', '', $request->cep);

        $total = 0;
        $listShippProducts = [];

        if ($request->has('product_id') && $product = Product::where('id', $request->product_id)->first()) {
            $listShippProducts[] = ['product' => $product, 'qtd' => 1];
            $total = $product->getRawOriginal('price');
        } else {
            $cart = CartController::storeOrUpdate(['shipping_cep' => $cep]);
            foreach ($cart->cartProducts as $cartProduct) {
                $product = $cartProduct->product;
                $listShippProducts[] = ['product' => $product, 'qtd' => $cartProduct->qtd];
                $total += $product->getRawOriginal('price');
            }
        }

        $shippings = self::getShippings($cep, $listShippProducts, $total, $request->has("inputs"));

        $lowestValue = $shippings['lowestValue'];
        $htmlShipping = $shippings['html'];

        if (!is_null($lowestValue)) {
            CartController::storeOrUpdate([
                'shipping_cep' => substr($cep, 0, 5) . '-' . substr($cep, 5, 8),
                'shipping_value' => $lowestValue,
            ]);
        }

        return json_encode(['html' => !is_null($lowestValue) ? $htmlShipping : '<b>Falha no cálculo</b>']);
    }

    public static function calcShipping($cep, $cartProducts) {
        $cep = preg_replace('/[^0-9]/', '', $cep);

        $total = 0;
        $listShippProducts = [];
        foreach ($cartProducts as $cartProduct) {
            $product = $cartProduct->product;
            $listShippProducts[] = ['product' => $product, 'qtd' => $cartProduct->qtd];
            $total += $product->getRawOriginal('price');
        }

        $shippings = self::getShippings($cep, $listShippProducts, $total, true);

        return $shippings['html'];
    }

    public static function getShippings($cep, $listShippProducts, $total, $inputs = false) {

        $lowestValue = null;
        $htmlShipping = '<ul>';

        if ($frenetCalc = FrenetController::calcShipping($cep, $listShippProducts, $total, $inputs)) {
            $htmlShipping .= $frenetCalc['html'];
            if (is_null($lowestValue) || $frenetCalc['lowestValue'] < $lowestValue) {
                $lowestValue = $frenetCalc['lowestValue'];
            }
        }

        if ($correioCalc = CorreioController::calcShipping($cep, $listShippProducts, $inputs)) {
            $htmlShipping .= $correioCalc['html'];
            if (is_null($lowestValue) || $correioCalc['lowestValue'] < $lowestValue) {
                $lowestValue = $correioCalc['lowestValue'];
            }
        }

        $htmlShipping .= '</ul>';

        return ['html' => $htmlShipping, 'lowestValue' => $lowestValue];
    }

    public static function getShippingValue($cep, $listShippProducts, $total, $shippingMethod, $shippingCode) {
        $shippingData = null;

        if ($shippingMethod == 'frenet') {
            $shippingData = FrenetController::calcShipping($cep, $listShippProducts, $total, shippingCode: $shippingCode);
        } else if ($shippingMethod == 'correios') {
            $shippingData = CorreioController::calcShipping($cep, $listShippProducts, $total, shippingCode: $shippingCode);
        }

        return $shippingData;
    }
}
