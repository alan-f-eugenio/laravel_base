<?php

namespace Modules\Email\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Email\Entities\Email;
use Modules\Email\Http\Requests\EmailRequest;

class EmailController extends Controller {
    public function store(EmailRequest $request) {
        $attributes = $request->validated();

        Email::create($attributes);

        return back();
    }
}
