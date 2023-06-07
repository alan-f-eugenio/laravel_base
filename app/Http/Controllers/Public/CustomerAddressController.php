<?php

namespace App\Http\Controllers\Public;

use App\Helpers\CustomerAddressTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\CustomerAddressRequest;
use App\Models\CustomerAddress;

class CustomerAddressController extends Controller {
    public function index() {
        $customer = auth()->user();

        return view('public.customer_address.index', [
            'customer' => $customer,
            'addresses' => $customer->addresses,
        ]);
    }

    public function create() {
        return view('public.customer_address.create_edit', [
            'item' => new CustomerAddress,
        ]);
    }

    public function store(CustomerAddressRequest $request) {
        $attributes = $request->validated();
        $attributes['type'] = CustomerAddressTypes::TYPE_ENTREGA->value;
        $attributes['customer_id'] = auth()->id();

        CustomerAddress::create($attributes);

        return redirect()->route('customer_address.index');
    }

    public function edit(CustomerAddress $customer_address) {

        return view('public.customer_address.create_edit', [
            'item' => $customer_address,
        ]);
    }

    public function update(CustomerAddressRequest $request, CustomerAddress $customer_address) {
        $attributes = $request->validated();

        $customer_address->update($attributes);

        return redirect()->route('customer_address.index');
    }
}
