<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Customer\Http\Requests\CustomerPasswordRequest;

class CustomerPasswordController extends Controller {
    public function edit() {
        return view('customer::public.customerPassword.edit');
    }

    public function update(CustomerPasswordRequest $request) {
        //
        $attributes = $request->validated();
        $attributes['password'] = bcrypt($attributes['password']);

        $request->user()->update($attributes);

        return redirect()->route('customer_password.edit');
    }
}
