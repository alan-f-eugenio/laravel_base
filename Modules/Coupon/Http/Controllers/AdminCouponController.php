<?php

namespace Modules\Coupon\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Helpers\CouponDiscountTypes;
use Modules\Coupon\Http\Requests\AdminCouponRequest;

class AdminCouponController extends Controller {
    public function index(Request $request) {
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

        $couponDiscountTypes = CouponDiscountTypes::array();

        return view('coupon::admin.index', ['collection' => $query->paginate(10), 'couponDiscountTypes' => $couponDiscountTypes]);
    }

    public function create() {
        $item = new Coupon;
        $couponDiscountTypes = CouponDiscountTypes::array();
        $typePercentValue = CouponDiscountTypes::TYPE_PERCENT->value;

        return view('coupon::admin.create_edit', [
            'item' => $item,
            'hasDateStartLimit' => (!old('hasDateStartLimit') && old('date_start')) || $item->date_start,
            'hasDateEndLimit' => (!old('hasDateEndLimit') && old('date_end')) || $item->date_end,
            'hasQtdLimit' => (!old('hasQtdLimit') && old('qtd') !== '' && old('qtd') !== null) || $item->qtd !== null,
            'hasValueMinLimit' => (!old('hasValueMinLimit') && old('value_min')) || $item->value_min,
            'hasValueMaxLimit' => (!old('hasValueMaxLimit') && old('value_max')) || $item->value_max,
            'couponDiscountTypes' => $couponDiscountTypes,
            'typePercentValue' => $typePercentValue,
        ]);
    }

    public function store(AdminCouponRequest $request) {
        $attributes = $request->validated();

        $attributes['create_user_id'] = auth('admin')->id();

        Coupon::create($attributes);

        return redirect()->route('admin.coupons.index')->with('message', ['type' => 'success', 'text' => 'Cupom cadastrado com sucesso.']);
    }

    public function edit(Coupon $coupon) {
        $couponDiscountTypes = CouponDiscountTypes::array();
        $typePercentValue = CouponDiscountTypes::TYPE_PERCENT->value;

        return view('coupon::admin.create_edit', [
            'item' => $coupon,
            'hasDateStartLimit' => (!old('hasDateStartLimit') && old('date_start')) || $coupon->date_start,
            'hasDateEndLimit' => (!old('hasDateEndLimit') && old('date_end')) || $coupon->date_end,
            'hasQtdLimit' => (!old('hasQtdLimit') && old('qtd') !== '' && old('qtd') !== null) || $coupon->qtd !== null,
            'hasValueMinLimit' => (!old('hasValueMinLimit') && old('value_min')) || $coupon->value_min,
            'hasValueMaxLimit' => (!old('hasValueMaxLimit') && old('value_max')) || $coupon->value_max,
            'couponDiscountTypes' => $couponDiscountTypes,
            'typePercentValue' => $typePercentValue,
        ]);
    }

    public function update(AdminCouponRequest $request, Coupon $coupon) {
        $attributes = $request->validated();

        $attributes['update_user_id'] = auth('admin')->id();

        $coupon->update($attributes);

        return redirect()->route('admin.coupons.edit', $coupon)->with('message', ['type' => 'success', 'text' => 'Cupom alterado com sucesso.']);
    }

    public function destroy(Coupon $coupon) {
        $coupon->update(['update_user_id' => auth('admin')->id()]);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('message', ['type' => 'success', 'text' => 'Cupom removido com sucesso.']);
    }
}
