<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller {
    public function store(ContactRequest $request) {
        $attributes = $request->validated();
        $attributes['subject'] = 'Contato do Site';

        Contact::create($attributes);

        return back();
    }
}
