<?php

namespace Modules\Pagseguro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PagseguroController extends Controller {
    public function index() {
        return view('pagseguro::admin.index');
    }

    public function create() {
        return view('pagseguro::create');
    }

    public function store(Request $request) {
        //
    }

    public function show($id) {
        return view('pagseguro::show');
    }

    public function edit($id) {
        return view('pagseguro::edit');
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
