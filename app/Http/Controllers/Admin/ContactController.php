<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
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

        return view('admin.contacts.index', ['collection' => $query->paginate(10)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact) {
        //
        if (!$contact->seen) {
            $contact->update(['seen' => 1, 'update_user_id' => auth('admin')->id()]);
        }

        return view('admin.contacts.show', ['item' => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact) {
        //
        $contact->update(['update_user_id' => auth('admin')->id()]);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('message', ['type' => 'success', 'text' => 'Contato removido com sucesso.']);
    }
}
