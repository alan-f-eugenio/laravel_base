<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contact\Entities\Contact;

class AdminContactController extends Controller {
    public function index(Request $request) {
        $query = Contact::orderBy('id', 'desc');

        $request->whenFilled('name', function ($value) use ($query) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('email', function ($value) use ($query) {
            $query->where('email', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('subject', function ($value) use ($query) {
            $query->where('subject', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('seen', function ($value) use ($query) {
            $query->where('seen', $value);
        });

        return view('contact::admin.index', ['collection' => $query->paginate(10)]);
    }

    public function show(Contact $contact) {
        if (!$contact->seen) {
            $contact->update(['seen' => 1, 'update_user_id' => auth('admin')->id()]);
        }

        return view('contact::admin.show', ['item' => $contact]);
    }

    public function destroy(Contact $contact) {
        $contact->update(['update_user_id' => auth('admin')->id()]);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('message', ['type' => 'success', 'text' => 'Contato removido com sucesso.']);
    }
}
