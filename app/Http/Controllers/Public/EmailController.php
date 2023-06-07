<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\EmailRequest;
use App\Models\Email;

class EmailController extends Controller {
    public function store(EmailRequest $request) {
        $attributes = $request->validated();

        Email::create($attributes);

        return back();
    }
}
