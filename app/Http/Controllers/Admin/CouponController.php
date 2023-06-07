<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponAdminRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CouponController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
        $query = Coupon::orderBy('id', 'desc');

        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });
        $request->whenFilled('token', function ($value) use ($query) {
            $query->where('token', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('discount_type', function ($value) use ($query) {
            $query->where('discount_type', $value);
        });

        return view('admin.coupons.index', ['collection' => $query->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
        $item = new Coupon;

        return view('admin.coupons.create_edit', [
            'item' => $item,
            'hasDateStartLimit' => (!old('hasDateStartLimit') && old('date_start')) || $item->date_start,
            'hasDateEndLimit' => (!old('hasDateEndLimit') && old('date_end')) || $item->date_end,
            'hasQtdLimit' => (!old('hasQtdLimit') && old('qtd') !== '' && old('qtd') !== null) || $item->qtd !== null,
            'hasValueMinLimit' => (!old('hasValueMinLimit') && old('value_min')) || $item->value_min,
            'hasValueMaxLimit' => (!old('hasValueMaxLimit') && old('value_max')) || $item->value_max,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponAdminRequest $request) {
        //
        $attributes = $request->validated();

        $attributes['create_user_id'] = auth('admin')->id();

        Coupon::create($attributes);

        return redirect()->route('admin.coupons.index')->with('message', ['type' => 'success', 'text' => 'Cupom cadastrado com sucesso.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon) {
        //
        return view('admin.coupons.create_edit', [
            'item' => $coupon,
            'hasDateStartLimit' => (!old('hasDateStartLimit') && old('date_start')) || $coupon->date_start,
            'hasDateEndLimit' => (!old('hasDateEndLimit') && old('date_end')) || $coupon->date_end,
            'hasQtdLimit' => (!old('hasQtdLimit') && old('qtd') !== '' && old('qtd') !== null) || $coupon->qtd !== null,
            'hasValueMinLimit' => (!old('hasValueMinLimit') && old('value_min')) || $coupon->value_min,
            'hasValueMaxLimit' => (!old('hasValueMaxLimit') && old('value_max')) || $coupon->value_max,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponAdminRequest $request, Coupon $coupon) {
        //
        $attributes = $request->validated();

        $attributes['update_user_id'] = auth('admin')->id();

        $coupon->update($attributes);

        return redirect()->route('admin.coupons.edit', $coupon)->with('message', ['type' => 'success', 'text' => 'Cupom alterado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon) {
        //
        $coupon->update(['update_user_id' => auth('admin')->id()]);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('message', ['type' => 'success', 'text' => 'Cupom removido com sucesso.']);
    }
}
