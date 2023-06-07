<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CartController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
        $query = Cart::orderBy('updated_at', 'desc')->has('cartProducts');
            // ->whereDate('updated_at', '<=', Carbon::now()->subDay(1)->toDateString())

        $request->whenFilled('has_customer', function ($value) use ($query) {
            if ($value == 1) {
                $query->whereNotNull('customer_id');
            } else {
                $query->whereNull('customer_id');
            }
        });

        $request->whenFilled('name', function ($value) use ($query) {
            $query->whereHas('customer', function (Builder $query) use ($value) {
                $query->where('fullname', 'LIKE', "%{$value}%");
            });
        });

        $request->whenFilled('date', function ($value) use ($query) {
            if (strtotime($value) <= strtotime(Carbon::now()->subDay(1)->toDateString())) {
                $query->whereDate('updated_at', $value);
            }
        });

        return view('admin.carts.index', ['collection' => $query->with(['cartProducts', 'customer'])->paginate(10)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart) {
        //
        $cart->update(['update_user_id' => auth('admin')->id()]);
        $cart->delete();

        return redirect()->route('admin.carts.index')->with('message', ['type' => 'success', 'text' => 'Carrinho removido com sucesso.']);
    }
}
