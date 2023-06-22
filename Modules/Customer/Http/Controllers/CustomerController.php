<?php

namespace Modules\Customer\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Customer\Helpers\CustomerPersons;
use Modules\Customer\Http\Requests\CustomerAddressRequest;
use Modules\Customer\Http\Requests\CustomerRequest;

class CustomerController extends Controller {
    public function create() {
        $item = new Customer;
        $customerPersons = CustomerPersons::array();

        return view('customer::public.customer.create', [
            'item' => $item,
            'personFisica' => (old('person') ?: $item->person?->value) == CustomerPersons::PESSOA_FISICA->value || !$item->id,
            'address' => new CustomerAddress,
            'customerPersons' => $customerPersons,
        ]);
    }

    public function store(CustomerRequest $request, CustomerAddressRequest $addressRequest) {
        $attributes = $request->validated();
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['remember_token'] = Str::random(10);

        $mainAddAttributes = $addressRequest->validated();
        $mainAddAttributes['recipient'] = $attributes['fullname'];

        DB::transaction(function () use ($attributes, $mainAddAttributes) {
            $customer = Customer::create($attributes);
            $customer->addresses()->create($mainAddAttributes);
            auth('web')->login($customer, true);
        });

        $request->session()->regenerate();

        return redirect()->intended($request->has('url_return') ?: RouteServiceProvider::HOME);
    }

    public function edit() {
        $customer = auth()->user();
        $customerPersons = CustomerPersons::array();

        return view('customer::public.customer.edit', [
            'item' => $customer,
            'personFisica' => $customer->person->value == CustomerPersons::PESSOA_FISICA->value,
            'customerPersons' => $customerPersons,
        ]);
    }

    public function update(CustomerRequest $request) {
        $attributes = $request->validated();

        $request->user()->update($attributes);

        return redirect()->route('customer.edit');
    }
}
