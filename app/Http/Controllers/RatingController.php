<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function show()
    {
        $item = Rating::all();
        return RatingResource::collection($item);
    }

    public function store(Request $request){
        $item = new Rating();
        $itemExist = Rating::where('user_id', $request->input('user_id'))->where('book_id', $request->input('book_id'))->first();

        if ($itemExist) {
            return response()->json([
                'anda sudah beri ulasan buku ini'
            ]);
        }

        $item = Rating::create([
            'user_id' => $request->input('user_id'),
            'book_id' => $request->input('book_id'),
            'description' => $request->input('description'),
            'star' => $request->input('star'),
        ]);

        return response()->json([
            'message' => 'berhasil tambah ulasan',
            'user' => new RatingResource($item)
        ]);
    }

    public function update(Request $request, $id){
        $item = Rating::findOrFail($id);


        $item->update([
            'user_id' => $request->input('user_id'),
            'book_id' => $request->input('book_id'),
            'description' => $request->input('description'),
            'star' => $request->input('star'),
        ]);

        return response()->json([
            'message' => 'berhasil ubah ulasan',
            'user' => new RatingResource($item)
        ]);
    }

    public function destroy($id){
        $item = Rating::findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => 'berhasil hapus ulasan',
            'user' => new RatingResource($item)
        ]);
    }
}
