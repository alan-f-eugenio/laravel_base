<?php

namespace Modules\Email\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Email\Entities\Email;

class AdminEmailController extends Controller {
    public function index(Request $request) {
        $query = Email::orderBy('id', 'desc');

        $request->whenFilled('name', function ($value) use ($query) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('email', function ($value) use ($query) {
            $query->where('email', 'LIKE', "%{$value}%");
        });

        return view('email::admin.index', ['collection' => $query->paginate(10)]);
    }

    public function destroy(Email $email) {
        //
        $email->update(['update_user_id' => auth('admin')->id()]);
        $email->delete();

        return redirect()->route('admin.emails.index')->with('message', ['type' => 'success', 'text' => 'E-mail removido com sucesso.']);
    }
}
