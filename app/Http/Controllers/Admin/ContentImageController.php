<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentImageController extends Controller {
    public function index() {
        $urls = [];
        $listImages = Storage::allFiles('public/contents');
        foreach ($listImages as $img) {
            $urls[] = ['url' => asset('contents/' . basename($img))];
        }

        return stripslashes(json_encode($urls));
    }

    public function store(Request $request) {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $filename = request()->file('file')->store('contents', 'public');

        return stripslashes(json_encode(['link' => asset('storage/' . $filename)]));
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
