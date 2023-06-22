<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Http\Requests\ContactRequest;

class ContactController extends Controller {
    public function store(ContactRequest $request) {
        $attributes = $request->validated();
        $attributes['subject'] = 'Contato do Site';

        Contact::create($attributes);

        return back();
    }
}
