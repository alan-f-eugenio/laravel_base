<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
        $query = User::orderBy('id', 'desc');

        $request->whenFilled('name', function ($value) use ($query) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('email', function ($value) use ($query) {
            $query->where('email', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('admin.users.index', ['collection' => $query->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
        $item = new User;

        return view('admin.users.create_edit', ['item' => $item]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAdminRequest $request) {
        //
        $attributes = $request->validated();
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['create_user_id'] = auth('admin')->id();

        User::create($attributes);

        return redirect()->route('admin.users.index')->with('message', ['type' => 'success', 'text' => 'Usuário cadastrado com sucesso.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) {
        //
        return view('admin.users.create_edit', ['item' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserAdminRequest $request, User $user) {
        //
        $attributes = $request->validated();
        if (isset($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        }
        $attributes['update_user_id'] = auth('admin')->id();

        $user->update($attributes);

        return redirect()->route('admin.users.edit', $user)->with('message', ['type' => 'success', 'text' => 'Usuário alterado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) {
        //
        $user->update(['update_user_id' => auth('admin')->id()]);
        $user->delete();

        return redirect()->route('admin.users.index')->with('message', ['type' => 'success', 'text' => 'Usuário removido com sucesso.']);
    }
}
