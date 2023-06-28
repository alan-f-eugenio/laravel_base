<?php

namespace Modules\Content\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class AdminContentImageController extends Controller {
    public function index() {
        $urls = [];
        $listImages = Storage::allFiles('public/contents');
        foreach ($listImages as $img) {
            $urls[] = ['url' => asset('storage/contents/' . basename($img))];
        }

        return stripslashes(json_encode($urls));
    }

    public function store(Request $request) {
        $request->validate([
            'upload' => 'required|image|max:5120',
        ]);

        $filename = request()->file('upload')->store('contents', 'public');

        return stripslashes(json_encode(['url' => asset('storage/' . $filename)]));
    }

    public function destroy(Request $request) {

        $img = '';
        if (isset($request->src)) {
            $img = $request->src;
        } elseif ($request->getContent()) {
            $body = json_decode($request->getContent());
            $img = $body->img;
        }

        Storage::delete('public/contents/' . basename($img));

        return response()->json(['deleted' => true]);
    }
}
