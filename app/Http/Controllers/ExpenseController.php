<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\UserPocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'pocket_id' => ['required', 'uuid'],
            'amount'    => ['required', 'numeric', 'min:1'],
            'notes'     => ['nullable', 'string'],
        ]);

        [$expense, $pocket] = DB::transaction(function () use ($data) {
            $pocket = UserPocket::query()
                ->where('id', $data['pocket_id'])
                ->where('user_id', auth('api')->id())
                ->lockForUpdate()
                ->firstOrFail();

            if ($pocket->balance < $data['amount']) {
                return response()->json([
                    'status'  => 400,
                    'error'   => true,
                    'message' => 'Saldo tidak mencukupi.',
                ], 400)->throwResponse();
            }

            $expense = Expense::create([
                'user_id'   => auth('api')->id(),
                'pocket_id' => $pocket->id,
                'amount'    => $data['amount'],
                'notes'     => $data['notes'] ?? null,
            ]);

            $pocket->decrement('balance', $data['amount']);
            $pocket->refresh();

            return [$expense, $pocket];
        });

        return response()->json([
            'status'  => 200,
            'error'   => false,
            'message' => 'Berhasil menambahkan expense.',
            'data'    => [
                'id'              => $expense->id,
                'pocket_id'       => $pocket->id,
                'current_balance' => $pocket->balance,
            ],
        ]);
    }
}