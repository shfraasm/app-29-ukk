<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UserController::class , 'logout']);
});

// auth
Route::post('/login', [UserController::class , 'login']);
Route::post('/register', [UserController::class , 'register']);
Route::get('/profile', [UserController::class , 'profile']);

//operator
Route::post('/operators', [UserController::class , 'storeOperator']);
Route::get('/users-petugas', [UserController::class , 'showUser1']);


Route::get('/users-admin', [UserController::class , 'showUser0']);
Route::post('/admins', [UserController::class , 'storeAdmin']);

Route::post('/users-all', [UserController::class , 'store']);

// user
Route::post('/users', [UserController::class , 'storeUser']);
Route::get('/users-peminjam', [UserController::class , 'showUser2']);

// update, delete, get user/operator
Route::get('/users/{id}', [UserController::class , 'getById']);
Route::put('/users/{id}', [UserController::class , 'update']);
Route::delete('/users/{id}', [UserController::class , 'destroy']);

// search user multilevel
Route::get('/search-users', [UserController::class , 'searchUser2']);
Route::get('/search-operators', [UserController::class , 'searchUser1']);
Route::get('/search-admins', [UserController::class , 'searchUser0']);

// books
Route::get('/books', [BookController::class , 'show']);
Route::get('/books/{id}', [BookController::class , 'getById']);
Route::post('/books', [BookController::class , 'store']);
Route::put('/books/{id}', [BookController::class , 'update']);
Route::delete('/books/{id}', [BookController::class , 'destroy']);
Route::get('/search-books', [BookController::class , 'search']);


// ratings
Route::get('/ratings', [RatingController::class , 'show']);
Route::get('/ratings/{id}', [RatingController::class , 'getById']);
Route::post('/ratings', [RatingController::class , 'store']);
Route::put('/ratings/{id}', [RatingController::class , 'update']);
Route::delete('/ratings/{id}', [RatingController::class , 'destroy']);

// borrowings
Route::get('/search-borrows', [BorrowingController::class , 'search']);
Route::get('/borrowings', [BorrowingController::class , 'show']);
Route::get('/borrowings/{id}', [BorrowingController::class , 'getById']);
Route::post('/borrowings', [BorrowingController::class , 'store']);
Route::put('/borrowings/{id}', [BorrowingController::class , 'update']);
Route::delete('/borrowings/{id}', [BorrowingController::class , 'destroy']);

// collections
Route::get('/collections', [CollectionController::class , 'show']);
Route::get('/collections/all', [CollectionController::class , 'showAll']);
Route::get('/has-collection', [CollectionController::class , 'showByBookId']);
Route::post('/collections', [CollectionController::class , 'store']);
Route::delete('/collections/{id}', [CollectionController::class , 'destroy']);
Route::delete('/collections-delete', [CollectionController::class , 'destroyByUserId']);

