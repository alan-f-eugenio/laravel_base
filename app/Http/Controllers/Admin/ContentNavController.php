<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentNavAdminRequest;
use App\Models\ContentNav;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentNavController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // dd($request, $nav);
        //
        $query = ContentNav::orderBy('id', 'desc');

        $request->whenFilled('title', function ($value) use ($query) {
            $query->where('title', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('admin.contentNavs.index', ['collection' => $query->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
        $item = new ContentNav;

        return view('admin.contentNavs.create_edit', ['item' => $item]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentNavAdminRequest $request) {
        //
        $attributes = $request->validated();

        $attributes['slug'] = Str::slug($attributes['title']);
        $attributes['create_user_id'] = auth('admin')->id();

        ContentNav::create($attributes);

        return redirect()->route('admin.contentNavs.index')->with('message', ['type' => 'success', 'text' => 'Página de conteúdo cadastrada com sucesso.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentNav $contentNav) {
        //
        // dd($contentNav);
        return view('admin.contentNavs.create_edit', ['item' => $contentNav]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentNavAdminRequest $request, ContentNav $contentNav) {
        //
        $attributes = $request->validated();

        $attributes['slug'] = Str::slug($attributes['title']);
        $attributes['update_user_id'] = auth('admin')->id();

        $contentNav->update($attributes);

        return redirect()->route('admin.contentNavs.edit', $contentNav)->with('message', ['type' => 'success', 'text' => 'Página de conteúdo alterado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentNav $contentNav) {
        //
        $contentNav->update(['update_user_id' => auth('admin')->id()]);
        $contentNav->delete();

        return redirect()->route('admin.contentNavs.index')->with('message', ['type' => 'success', 'text' => 'Página de conteúdo removida com sucesso.']);
    }
}
