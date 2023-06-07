<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DefineAdminRequest;

class DefineController extends Controller {
    /**
     * Show the form for editing the specified resource.
     */
    public function edit() {
        //
        $define = config('defines');

        return view('admin.defines.edit', ['item' => $define]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DefineAdminRequest $request) {
        //
        $define = config('defines');

        $attributes = $request->validated();

        $attributes['update_user_id'] = auth('admin')->id();

        $define->update($attributes);

        return redirect()->route('admin.defines.edit')->with('message', ['type' => 'success', 'text' => 'Definições alteradas com sucesso.']);
    }
}
