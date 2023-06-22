<?php

namespace Modules\Content\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Content\Entities\Content;
use Modules\Content\Entities\ContentNav;
use Modules\Content\Http\Requests\AdminContentRequest;

class AdminContentController extends Controller {
    public function index(Request $request, ContentNav $nav) {
        $query = Content::orderBy('id', 'desc')->where('content_nav_id', $nav->id);

        $request->whenFilled('title', function ($value) use ($query) {
            $query->where('title', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('content::admin.content.index', ['collection' => $query->paginate(10), 'nav' => $nav]);
    }

    public function create(ContentNav $nav) {
        $item = new Content;

        return view('content::admin.content.create_edit', ['item' => $item, 'nav' => $nav]);
    }

    public function store(AdminContentRequest $request, ContentNav $nav) {
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            $attributes['filename'] = request()->file('filename')->store('contents', 'public');
        }
        $attributes['slug'] = str($attributes['title'])->slug();
        $attributes['create_user_id'] = auth('admin')->id();
        $attributes['content_nav_id'] = $nav->id;

        Content::create($attributes);

        return redirect()->route('admin.content.index', $nav->id)->with('message', ['type' => 'success', 'text' => 'Conteúdo cadastrado com sucesso.']);
    }

    public function edit(Content $content) {
        return view('content::admin.content.create_edit', ['item' => $content, 'nav' => $content->nav]);
    }

    public function update(AdminContentRequest $request, Content $content) {
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            Storage::delete('public/' . $content->filename);
            $attributes['filename'] = request()->file('filename')->store('contents', 'public');
        }
        $attributes['slug'] = str($attributes['title'])->slug();
        $attributes['update_user_id'] = auth('admin')->id();

        $content->update($attributes);

        return redirect()->route('admin.contents.edit', $content)->with('message', ['type' => 'success', 'text' => 'Conteúdo alterado com sucesso.']);
    }

    public function destroy(Content $content) {
        $nav = $content->nav;

        $content->update(['update_user_id' => auth('admin')->id()]);
        $content->delete();

        return redirect()->route('admin.contents.index', $nav->id)->with('message', ['type' => 'success', 'text' => 'Conteúdo removido com sucesso.']);
    }
}
