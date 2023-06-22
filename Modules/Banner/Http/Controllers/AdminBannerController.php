<?php

namespace Modules\Banner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Entities\BannerLocal;
use Modules\Banner\Http\Requests\AdminBannerRequest;

class AdminBannerController extends Controller {
    public function index(Request $request) {
        $query = Banner::orderBy('local_id', 'desc')->orderBy('ordem', 'asc');

        $request->whenFilled('title', function ($value) use ($query) {
            $query->where('title', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('local_id', function ($value) use ($query) {
            $query->where('local_id', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        $bannerLocals = BannerLocal::all();

        return view('banner::admin.index', ['collection' => $query->get()->mapToGroups(function ($item) {
            return [$item->local->title => $item];
        }), 'bannerLocals' => $bannerLocals]);
    }

    public function create() {
        $item = new Banner;
        $bannerLocals = BannerLocal::all();

        return view('banner::admin.create_edit', ['item' => $item, 'bannerLocals' => $bannerLocals]);
    }

    public function store(AdminBannerRequest $request) {
        //
        $attributes = $request->validated();

        $attributes['filename'] = request()->file('filename')->store('banners', 'public');
        $attributes['create_user_id'] = auth('admin')->id();

        Banner::create($attributes);

        return redirect()->route('admin.banners.index')->with('message', ['type' => 'success', 'text' => 'Banner cadastrado com sucesso.']);
    }

    public function edit(Banner $banner) {
        $bannerLocals = BannerLocal::all();

        return view('banner::admin.create_edit', ['item' => $banner, 'bannerLocals' => $bannerLocals]);
    }

    public function update(AdminBannerRequest $request, Banner $banner) {
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            Storage::delete('public/' . $banner->filename);
            $attributes['filename'] = request()->file('filename')->store('banners', 'public');
        }
        $attributes['update_user_id'] = auth('admin')->id();

        $banner->update($attributes);

        return redirect()->route('admin.banners.edit', $banner)->with('message', ['type' => 'success', 'text' => 'Banner alterado com sucesso.']);
    }

    public function destroy(Banner $banner) {
        $banner->update(['update_user_id' => auth('admin')->id()]);
        Storage::delete('public/' . $banner->filename);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('message', ['type' => 'success', 'text' => 'Banner removido com sucesso.']);
    }

    public function updateOrdenation(Request $request) {

        foreach ($request->all() as $bannerTr) {
            if ($banner = Banner::find($bannerTr['id'])) {
                $banner->timestamps = false;
                $banner->update(['ordem' => $bannerTr['ordem']]);
            }
        }

        return json_encode(['success' => true]);
    }
}
