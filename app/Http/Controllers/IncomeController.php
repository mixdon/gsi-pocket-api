<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\UserPocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'pocket_id' => ['required', 'uuid'],
            'amount'    => ['required', 'numeric', 'min:1'],
            'notes'     => ['nullable', 'string'],
        ]);

        [$income, $pocket] = DB::transaction(function () use ($data) {
            $pocket = UserPocket::query()
                ->where('id', $data['pocket_id'])
                ->where('user_id', auth('api')->id())
                ->lockForUpdate()
                ->firstOrFail();

            $income = Income::create([
                'user_id'   => auth('api')->id(),
                'pocket_id' => $pocket->id,
                'amount'    => $data['amount'],
                'notes'     => $data['notes'] ?? null,
            ]);

            $pocket->increment('balance', $data['amount']);
            $pocket->refresh();

            return [$income, $pocket];
        });

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil menambahkan income.',
            'data'    => [
                'id'              => $income->id,
                'pocket_id'       => $pocket->id,
                'current_balance' => $pocket->balance,
            ],
        ]);
    }
}