<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showUser1()
    {
        $item = User::where('roles', 1)->get();
        return UserResource::collection($item);
    }

    public function showUser2()
    {
        $item = User::where('roles', 2)->get();
        return UserResource::collection($item);
    }

    public function showUser0()
    {
        $item = User::where('roles', 0)->get();
        return UserResource::collection($item);
    }

    public function profile(Request $request)
    {
        $userId = $request->input('id');
        $item = User::where('id', $userId)->get();
        return UserResource::collection($item);
    }

    public function searchUser2(Request $request)
    {
        $keyword = $request->input('keyword');

        $item = User::where('roles', 2)->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', "%$keyword%")
            ->orWhere('username', 'LIKE', "%$keyword%")
            ->orWhere('email', 'LIKE', "%$keyword%");
        });

        $item = $item->get();

        return UserResource::collection($item);

    }

    public function searchUser1(Request $request)
    {
         $keyword = $request->input('keyword');

        $item = User::where('roles', 1)->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', "%$keyword%")
            ->orWhere('username', 'LIKE', "%$keyword%")
            ->orWhere('email', 'LIKE', "%$keyword%");
        });

        $item = $item->get();

        return UserResource::collection($item);
    }

    public function searchUser0(Request $request)
    {
         $keyword = $request->input('keyword');

        $item = User::where('roles', 0)->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', "%$keyword%")
            ->orWhere('username', 'LIKE', "%$keyword%")
            ->orWhere('email', 'LIKE', "%$keyword%");
        });

        $item = $item->get();

        return UserResource::collection($item);
    }

    public function getById($id)
    {
        $item = User::findOrFail($id);

        if ($item) {
            return response()->json([
                'message' => 'menampilkan user',
                'data' => new UserResource($item)
            ]);
        } else {
            return response()->json([
                'message' => 'gagal menampilkan user',
                'data' => null
            ]);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ])) {
            return response()->json([
                'message' => 'Username/Password tidak valid'
            ]);
        }
        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'berhasil login',
            'user' => Auth::user(),
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->delete();
        return response()->json([
            'message' => 'berhasil logout',

        ]);
    }

    public function register(Request $request)
    {
        $item = new User();

        $item = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'roles' => 2,
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'message' => 'berhasil tambah user',
            'data' => new UserResource($item)
        ]);
    }

    public function storeUser(Request $request)
    {
        $item = new User();

        $item = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'roles' => 2,
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'message' => 'berhasil tambah user',
            'data' => new UserResource($item)
        ]);
    }

    public function storeOperator(Request $request)
    {
        $item = new User();

        $item = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'roles' => 1,
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'message' => 'berhasil tambah operator',
            'data' => new UserResource($item)
        ]);
    }

    public function storeAdmin(Request $request)
    {
        $item = new User();

        $item = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'roles' => 0,
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'message' => 'berhasil tambah admin',
            'data' => new UserResource($item)
        ]);
    }

    public function store(Request $request)
    {
        $item = new User();

        $item = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'roles' => $request->input('roles'),
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'message' => 'berhasil tambah operator',
            'data' => new UserResource($item)
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = User::findOrFail($id);

        $item->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'message' => 'berhasil ubah user',
            'data' => new UserResource($item)
        ]);
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);

        $item->delete();

        return response()->json([
            'message' => 'berhasil hapus user',
            'data' => new UserResource($item)
        ]);
    }
}
