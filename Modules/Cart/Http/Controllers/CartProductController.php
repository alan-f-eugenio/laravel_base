<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cart\Entities\CartProduct;
use Modules\Product\Entities\Product;

class CartProductController extends Controller {
    public function index() {
        $cart = CartController::storeOrUpdate();

        return view('cart::public.index', ['cart' => $cart->load(
            'cartProducts.product.parent',
            'cartProducts.product.attribute1',
            'cartProducts.product.option1',
            'cartProducts.product.attribute2',
            'cartProducts.product.option2',
        )]);
    }

    public function store(Request $request, Product $product) {

        $cart = CartController::storeOrUpdate();

        $currentCartProducts = $cart->allCartProducts;
        $currentCPKey = $currentCartProducts->search(fn ($item) => $item['product_id'] == $product->id);

        if ($currentCPKey !== false) {
            $cartProduct = $currentCartProducts[$currentCPKey];
            if ($cartProduct->deleted_at) {
                $cartProduct->qtd = $request->qtd;
                $cartProduct->created_at = now();
                $cartProduct->updated_at = now();
                $cartProduct->deleted_at = null;
            } else {
                $cartProduct->qtd += $request->qtd;
            }
        } else {
            $cartProduct = new CartProduct([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qtd' => $request->qtd,
            ]);
        }

        if ($product->type->venda() && $cartProduct->qtd > $product->stock) {
            $cartProduct->qtd = $product->stock;
        }

        $cartProduct->save();

        return redirect(route('cart_product.index'));
    }

    public function update(Request $request, CartProduct $cart_product) {

        $cart_product->qtd = $request->qtd;

        if ($cart_product->product->type->venda() && $cart_product->qtd > $cart_product->product->stock) {
            $cart_product->qtd = $cart_product->product->stock;
        }

        $cart_product->save();

        return redirect(route('cart_product.index'));
    }

    public function destroy(CartProduct $cart_product) {

        $cart_product->delete();

        return redirect(route('cart_product.index'));
    }
}
