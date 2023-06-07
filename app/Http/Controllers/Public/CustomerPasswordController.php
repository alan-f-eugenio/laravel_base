<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\CustomerPasswordRequest;

class CustomerPasswordController extends Controller {
    public function edit() {
        return view('public.customer_password.edit');
    }

    public function update(CustomerPasswordRequest $request) {
        //
        $attributes = $request->validated();
        $attributes['password'] = bcrypt($attributes['password']);

        $request->user()->update($attributes);

        return redirect()->route('customer_password.edit');
    }
}
