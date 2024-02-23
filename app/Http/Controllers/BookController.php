<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function show()
    {
        $item = Book::all();
        return BookResource::collection($item);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $item = Book::Where('name', 'LIKE', "%$keyword%")
            ->orWhere('category', 'LIKE', "%$keyword%")
            ->orWhere('remaining_stock', 'LIKE', "%$keyword%")
            ->orWhere('author', 'LIKE', "%$keyword%")
            ->orWhere('publisher', 'LIKE', "%$keyword%")
            ->orWhere('published_year', 'LIKE', "%$keyword%")->get();

        return BookResource::collection($item);
    }

    public function getById($id)
    {
        $item = Book::findOrFail($id);

        $totalRating = Rating::where('book_id', $item->id)->sum('star');
        $dataRating = Rating::where('book_id', $item->id)->count();

        if ($dataRating > 0) {
            $item->total_rating = $totalRating / $dataRating;
            $item->total_rating = round($item->total_rating, 1);
        }

        if ($item) {
            return response()->json([
                'message' => 'menampilkan book',
                'data' => new BookResource($item)
            ]);
        } else {
            return response()->json([
                'message' => 'gagal menampilkan book',
                'data' => null
            ]);
        }
    }

    public function store(Request $request)
    {
        $item = new Book();

        $image = $request->file('photo');
        $name = $image->getClientOriginalName();
        $image->storeAs('public/books/', $name);
        $photoPath = '/books/' . $name;

        $item = Book::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'photo' => $photoPath,
            'category' => $request->input('category'),
            'remaining_stock' => $request->input('remaining_stock'),
            'author' => $request->input('author'),
            'publisher' => $request->input('publisher'),
            'published_year' => $request->input('published_year'),
        ]);

        return response()->json([
            'message' => 'berhasil tambah buku',
            'data' => new BookResource($item)
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Book::findOrFail($id);

        if ($request->hasFile('photo')) {
            if (Storage::exists('public/' . $item->photo)) {
                Storage::delete('public/' . $item->photo);
            }

            $image = $request->file('photo');
            $name = $image->getClientOriginalName();
            $image->storeAs('public/books/', $name);
            $photoPath = '/books/' . $name;
            $item->photo = $photoPath;

            $item->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'category' => $request->input('category'),
                'remaining_stock' => $request->input('remaining_stock'),
                'author' => $request->input('author'),
                'publisher' => $request->input('publisher'),
                'published_year' => $request->input('published_year'),
            ]);

            return response()->json([
                'message' => 'berhasil ubah buku',
                'data' => new BookResource($item)
            ]);
        }
    }

    public function destroy($id)
    {
        $item = Book::findOrFail($id);
        $name = basename($item->photo);
        Storage::delete('public/books/' . $name);
        $item->delete();

        return response()->json([
            'message' => 'berhasil hapus buku',
            'data' => new BookResource($item)
        ]);
    }
}
