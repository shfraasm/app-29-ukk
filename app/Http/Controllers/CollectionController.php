<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{

    public function showAll()
    {
        $item = Collection::all();
        return CollectionResource::collection($item);
    }

    public function show(Request $request)
    {
        $userId = $request->input('user_id');
        $item = Collection::where('user_id', $userId)->get();
        return CollectionResource::collection($item);
    }

    public function showByBookId(Request $request)
    {
        $userId = $request->input('user_id');
        $bookId = $request->input('book_id');
        $item = Collection::where('user_id', $userId)->where('book_id', $bookId)->get();
        return CollectionResource::collection($item);
    }



    public function store(Request $request)
    {
        $item = new Collection();
        $itemExist = Collection::where('user_id', $request->input('user_id'))->where('book_id', $request->input('book_id'))->first();

        if ($itemExist) {
            return response()->json([
                'buku ini sudah tersimpan di koleksi anda'
            ]);
        }

        $item = Collection::create([
            'user_id' => $request->input('user_id'),
            'book_id' => $request->input('book_id'),

        ]);

        return response()->json([
            'message' => 'berhasil tambah koleksi',
            'user' => new CollectionResource($item)
        ]);
    }

    public function destroy($id)
    {
        $item = Collection::findOrFail($id);


        $item->delete();

        return response()->json([
            'message' => 'berhasil hapus koleksi',
            'user' => new CollectionResource($item)
        ]);
    }

    public function destroyByUserId(Request $request)
    {
        $userId = $request->input('user_id');
        $bookId = $request->input('book_id');
        $item = Collection::where('user_id', $userId)->where('book_id', $bookId)->delete();
        return response()->json([
            'message' => 'berhasil hapus koleksi',
        ]);
    }
}
