<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status'  => 401,
                'error'   => true,
                'message' => 'Login gagal.',
            ], 401);
        }

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil login.',
            'data'    => [
                'token' => $token,
            ],
        ]);
    }

    public function profile()
    {
        $user = auth('api')->user();

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil login.',
            'data'    => [
                'full_name' => $user->full_name,
                'email'     => $user->email,
            ],
        ]);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil logout.',
        ]);
    }
}