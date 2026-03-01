<?php

namespace App\Http\Controllers;

use App\Models\UserPocket;
use Illuminate\Http\Request;

class PocketController extends Controller
{
    public function index()
    {
        $pockets = UserPocket::query()
            ->where('user_id', auth('api')->id())
            ->get()
            ->map(function ($pocket) {
                return [
                    'id'              => $pocket->id,
                    'name'            => $pocket->name,
                    'current_balance' => $pocket->balance,
                ];
            });

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil.',
            'data'    => $pockets,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => ['required', 'string'],
            'initial_balance' => ['required', 'numeric', 'min:0'],
        ]);

        $pocket = UserPocket::create([
            'user_id' => auth('api')->id(),
            'name'    => $data['name'],
            'balance' => $data['initial_balance'],
        ]);

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil membuat pocket baru.',
            'data'    => [
                'id' => $pocket->id,
            ],
        ]);
    }

    public function totalBalance()
    {
        $total = UserPocket::where('user_id', auth('api')->id())
            ->sum('balance');

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil.',
            'data'    => [
                'total' => $total,
            ],
        ]);
    }
}