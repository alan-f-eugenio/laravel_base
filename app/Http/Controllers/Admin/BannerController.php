<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerAdminRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
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

        return view('admin.banners.index', ['collection' => $query->get()->mapToGroups(function ($item) {
            return [$item->local->title => $item];
        })]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
        $item = new Banner;

        return view('admin.banners.create_edit', ['item' => $item]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerAdminRequest $request) {
        //
        $attributes = $request->validated();

        $attributes['filename'] = request()->file('filename')->store('banners', 'public');
        $attributes['create_user_id'] = auth('admin')->id();

        Banner::create($attributes);

        return redirect()->route('admin.banners.index')->with('message', ['type' => 'success', 'text' => 'Banner cadastrado com sucesso.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner) {
        //
        return view('admin.banners.create_edit', ['item' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerAdminRequest $request, Banner $banner) {
        //
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            Storage::delete('public/' . $banner->filename);
            $attributes['filename'] = request()->file('filename')->store('banners', 'public');
        }
        $attributes['update_user_id'] = auth('admin')->id();

        $banner->update($attributes);

        return redirect()->route('admin.banners.edit', $banner)->with('message', ['type' => 'success', 'text' => 'Banner alterado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner) {
        //
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
