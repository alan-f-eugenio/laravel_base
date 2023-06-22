<?php

namespace Modules\Content\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Content\Entities\ContentNav;
use Modules\Content\Helpers\ContentNavTypes;
use Modules\Content\Http\Requests\AdminContentNavRequest;

class AdminContentNavController extends Controller {
    public function index(Request $request) {
        $query = ContentNav::orderBy('id', 'desc');

        $request->whenFilled('title', function ($value) use ($query) {
            $query->where('title', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('content::admin.contentNav.index', ['collection' => $query->paginate(10)]);
    }

    public function create() {
        $item = new ContentNav;
        $contentNavTypes = ContentNavTypes::array();

        return view('content::admin.contentNav.create_edit', ['item' => $item, 'contentNavTypes' => $contentNavTypes]);
    }

    public function store(AdminContentNavRequest $request) {
        $attributes = $request->validated();

        $attributes['slug'] = str($attributes['title'])->slug();
        $attributes['create_user_id'] = auth('admin')->id();

        ContentNav::create($attributes);

        return redirect()->route('admin.contentNavs.index')->with('message', ['type' => 'success', 'text' => 'Página de conteúdo cadastrada com sucesso.']);
    }

    public function edit(ContentNav $contentNav) {
        $contentNavTypes = ContentNavTypes::array();

        return view('content::admin.contentNav.create_edit', ['item' => $contentNav, 'contentNavTypes' => $contentNavTypes]);
    }

    public function update(AdminContentNavRequest $request, ContentNav $contentNav) {
        $attributes = $request->validated();

        $attributes['slug'] = str($attributes['title'])->slug();
        $attributes['update_user_id'] = auth('admin')->id();

        $contentNav->update($attributes);

        return redirect()->route('admin.contentNavs.edit', $contentNav)->with('message', ['type' => 'success', 'text' => 'Página de conteúdo alterado com sucesso.']);
    }

    public function destroy(ContentNav $contentNav) {
        $contentNav->update(['update_user_id' => auth('admin')->id()]);
        $contentNav->delete();

        return redirect()->route('admin.contentNavs.index')->with('message', ['type' => 'success', 'text' => 'Página de conteúdo removida com sucesso.']);
    }
}
