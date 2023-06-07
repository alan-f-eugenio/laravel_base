<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentAdminRequest;
use App\Models\Content;
use App\Models\ContentNav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ContentNav $nav) {
        // dd($request, $nav);
        //
        $query = Content::orderBy('id', 'desc')->where('content_nav_id', $nav->id);

        $request->whenFilled('title', function ($value) use ($query) {
            $query->where('title', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('admin.contents.index', ['collection' => $query->paginate(10), 'nav' => $nav]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ContentNav $nav) {
        //
        $item = new Content;

        return view('admin.contents.create_edit', ['item' => $item, 'nav' => $nav]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentAdminRequest $request, ContentNav $nav) {
        //
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            $attributes['filename'] = request()->file('filename')->store('contents', 'public');
        }
        $attributes['slug'] = Str::slug($attributes['title']);
        $attributes['create_user_id'] = auth('admin')->id();
        $attributes['content_nav_id'] = $nav->id;

        Content::create($attributes);

        return redirect()->route('admin.contents.index', $nav->id)->with('message', ['type' => 'success', 'text' => 'Conteúdo cadastrado com sucesso.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content) {
        //
        return view('admin.contents.create_edit', ['item' => $content, 'nav' => $content->nav]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentAdminRequest $request, Content $content) {
        //
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            Storage::delete('public/' . $content->filename);
            $attributes['filename'] = request()->file('filename')->store('contents', 'public');
        }
        $attributes['slug'] = Str::slug($attributes['title']);
        $attributes['update_user_id'] = auth('admin')->id();

        $content->update($attributes);

        return redirect()->route('admin.contents.edit', $content)->with('message', ['type' => 'success', 'text' => 'Conteúdo alterado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content) {
        //
        $nav = $content->nav;

        $content->update(['update_user_id' => auth('admin')->id()]);
        $content->delete();

        return redirect()->route('admin.contents.index', $nav->id)->with('message', ['type' => 'success', 'text' => 'Conteúdo removido com sucesso.']);
    }
}
