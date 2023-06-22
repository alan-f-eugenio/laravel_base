<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Entities\CartProduct;

class CartController extends Controller {
    public static function storeOrUpdate(array $attributes = [], $oldSession = null) {
        $oldCart = $oldSession ? Cart::firstWhere('session_id', $oldSession) : null;

        $newCart = Cart::updateOrCreate(
            auth()->id() ? ['customer_id' => auth()->id()] : ['session_id' => session()->getId()],
            [
                'session_id' => session()->getId(),
                'customer_id' => auth()->id(),
                'updated_at' => now(),
                ...$attributes,
            ]
        );

        if ($oldCart && $oldCart->id != $newCart->id && $oldCart->cartProducts->count()) {
            $listOldCartProds = $oldCart->cartProducts;
            $listOldCartProdsIds = $oldCart->cartProducts->map(function ($item) {
                return $item->product->id;
            })->toArray();

            $listCurrentProdIds = [];

            foreach ($newCart->cartProducts as $newCartProd) {
                if (in_array($newCartProd->product->id, $listOldCartProdsIds)) {
                    $oldCartProd = $listOldCartProds->filter(function ($item) use ($newCartProd) {
                        if ($item->product->id == $newCartProd->product->id) {
                            return $item;
                        }
                    })->first();
                    $newCartProd->qtd = ($oldCartProd->qtd > $newCartProd->qtd ? $oldCartProd->qtd : $newCartProd->qtd);
                    $newCartProd->save();
                }
                $listCurrentProdIds[] = $newCartProd->product->id;
            }

            foreach ($oldCart->cartProducts as $oldCartProd) {
                if (!in_array($oldCartProd->product->id, $listCurrentProdIds)) {
                    CartProduct::create([
                        'cart_id' => $newCart->id,
                        'product_id' => $oldCartProd->product->id,
                        'qtd' => $oldCartProd->qtd,
                    ]);
                }
            }
        }

        return $newCart;
    }
}
