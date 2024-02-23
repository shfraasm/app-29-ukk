<?php

namespace App\Http\Controllers;

use App\Http\Resources\BorrowingResource;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function show()
    {
        $item = Borrowing::all();
        return BorrowingResource::collection($item);
    }

    public function getById($id)
    {
        $item = Borrowing::findOrFail($id);

        if ($item) {
            return response()->json([
                'message' => 'menampilkan peminjaan',
                'data' => new BorrowingResource($item)
            ]);
        } else {
            return response()->json([
                'message' => 'gagal menampilkan peminjaan',
                'data' => null
            ]);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $item = Borrowing::Where('quantity', 'LIKE', "%$keyword%")
            ->orWhere('start_date', 'LIKE', "%$keyword%")
            ->orWhere('end_date', 'LIKE', "%$keyword%")
            ->orWhere('status', 'LIKE', "%$keyword%")->get();

        return BorrowingResource::collection($item);
    }

    public function store(Request $request)
    {
        $item = new Borrowing();
        $book = $item->book;
        $item = Borrowing::create([
            'user_id' => $request->input('user_id'),
            'book_id' => $request->input('book_id'),
            'quantity' => $request->input('quantity'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => 'Dipinjam',
        ]);

        $book = Book::findOrFail($request->input('book_id'));
        $book->remaining_stock -= $request->input('quantity');
        $book->save();

        return response()->json([
            'message' => 'menambah peminjaan',
            'data' => new BorrowingResource($item)
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Borrowing::findOrFail($id);
        $oldQuantity = $item->quantity;
        $newQuantity = $request->input('quantity');
        $difference = $newQuantity - $oldQuantity;

        $book = $item->book;
        $newStock = $book->remaining_stock - $difference;

        $book->update([
            'remaining_stock' => $newStock
        ]);

        $item->update([
            'user_id' => $request->input('user_id'),
            'book_id' => $request->input('book_id'),
            'quantity' => $request->input('quantity'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'message' => 'mengubah peminjaan',
            'data' => new BorrowingResource($item)
        ]);
    }

    public function destroy($id)
    {
        $item = Borrowing::findOrFail($id);

        $book = $item->book;
        $newStock = $book->remaining_stock + $item->quantity;
        $book->update([
            'remaining_stock' => $newStock
        ]);

        $item->delete();
        return response()->json([
            'message' => 'menghapus peminjaan',
            'data' => new BorrowingResource($item)
        ]);
    }
}
