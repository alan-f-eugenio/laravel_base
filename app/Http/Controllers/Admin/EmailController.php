<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
        $query = Email::orderBy('id', 'desc');

        $request->whenFilled('name', function ($value) use ($query) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('email', function ($value) use ($query) {
            $query->where('email', 'LIKE', "%{$value}%");
        });

        return view('admin.emails.index', ['collection' => $query->paginate(10)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email) {
        //
        $email->update(['update_user_id' => auth('admin')->id()]);
        $email->delete();

        return redirect()->route('admin.emails.index')->with('message', ['type' => 'success', 'text' => 'E-mail removido com sucesso.']);
    }
}
