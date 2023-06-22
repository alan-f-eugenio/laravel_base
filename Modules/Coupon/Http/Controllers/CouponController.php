<?php

namespace Modules\Coupon\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cart\Http\Controllers\CartController;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Helpers\CouponDiscountTypes;

class CouponController extends Controller {
    public function __invoke(Request $request) {
        $total = 0;
        $discount = 0;

        $coupon = Coupon::firstWhere('token', $request->coupon);

        $cart = CartController::storeOrUpdate();

        foreach ($cart->cartProducts as $cartProduct) {
            $product = $cartProduct->product;
            $total += $product->getRawOriginal('price');
        }

        $validity = self::isCouponValid($coupon, $total);

        if ($validity['isValid']) {
            $discount = self::calcDiscount($coupon, $total);
        }

        CartController::storeOrUpdate([
            'coupon' => !is_null($coupon->token) && $validity['isValid'] ? $coupon->token : null,
        ]);

        return json_encode(['message' => $validity['message'], 'discount' => $discount]);
    }

    public static function isCouponValid(Coupon $coupon, $total) {
        $message = 'success';
        $isValid = true;

        $discount = self::calcDiscount($coupon, $total, false, false);

        if (!$coupon->id) {
            $isValid = false;
            $message = 'Cupom inválido';
        } elseif ($coupon->qtd === 0) {
            $isValid = false;
            $message = 'Cupom esgotado';
        } elseif ($coupon->date_start && $coupon->date_start > Carbon::now()) {
            $isValid = false;
            $message = 'Cupom estará disponível a partir de: ' . Carbon::parse($coupon->date_start)->format('d/m/Y H:i:s');
        } elseif ($coupon->date_end && $coupon->date_end < Carbon::now()) {
            $isValid = false;
            $message = 'Cupom expirado';
        } elseif ($coupon->getRawOriginal('value_min') && $coupon->getRawOriginal('value_min') > $total) {
            $isValid = false;
            $message = 'Valor mínimo para utilizar o cupom é de R$ ' . $coupon->value_min;
        } elseif ($coupon->getRawOriginal('value_max') && $coupon->getRawOriginal('value_max') < $total) {
            $isValid = false;
            $message = 'Valor máximo para utilizar o cupom é de R$ ' . $coupon->value_max;
        } elseif ($discount > $total) {
            $isValid = false;
            $message = 'Valor do pedido não pode ser menor que o valor do desconto';
        }
        // CRIAR VALIDAÇÃO FIRST_BUY

        return ['isValid' => $isValid, 'message' => $message];
    }

    public static function calcDiscount(Coupon $coupon, $total, $masked = true, $returnTotal = false) {
        if ($coupon->discount_type == CouponDiscountTypes::TYPE_AMOUNT) {
            $discount = $coupon->getRawOriginal('discount');
        } else {
            $discount = $total * ($coupon->getRawOriginal('discount') / 100);
        }
        $return = $returnTotal ? $total - $discount : $discount;

        return $masked ? '- R$ ' . str_replace('.', ',', $return) : $return;
    }
}
