<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\registerRequest;
use App\Http\Requests\loginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(registerRequest $request) 
    {
        $user = User::create([
            "email" => $request->email,
            "password" => $request->password,
            'role' => 'user'
        ]);

        $user->profile()->create([
            'full_name' => $request->fullname
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Register successfull',
            'data' => [
                'id' => $user->id,
                'fullname' => $user->profile->full_name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ], 201);
    }

    public function login(loginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => "failed",
                'message' => 'Email atau password salah'
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Login berhasil',
            'data'    => [
                'id' => $user->id,
                'fullname' => $user->profile->full_name,
                'email' => $user->email,
                'role' => $user->role,
                'access_token' => $token
            ]
        ]);

    }
}
