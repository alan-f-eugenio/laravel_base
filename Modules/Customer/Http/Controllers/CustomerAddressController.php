<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Customer\Helpers\CustomerAddressTypes;
use Modules\Customer\Http\Requests\CustomerAddressRequest;

class CustomerAddressController extends Controller {
    public function index() {
        $customer = auth()->user();

        return view('customer::public.customerAddress.index', [
            'customer' => $customer,
            'addresses' => $customer->addresses,
        ]);
    }

    public function create() {
        return view('customer::public.customerAddress.create_edit', [
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

        return view('customer::public.customerAddress.create_edit', [
            'item' => $customer_address,
        ]);
    }

    public function update(CustomerAddressRequest $request, CustomerAddress $customer_address) {
        $attributes = $request->validated();

        $customer_address->update($attributes);

        return redirect()->route('customer_address.index');
    }
}
