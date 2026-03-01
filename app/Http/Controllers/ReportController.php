<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePocketReportJob;
use App\Models\UserPocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function create(Request $request, string $id)
    {
        $data = $request->validate([
            'type' => ['required', 'in:INCOME,EXPENSE'],
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        $pocket = UserPocket::where('id', $id)
            ->where('user_id', auth('api')->id())
            ->first();

        if (! $pocket) {
            return response()->json([
                'status' => 404,
                'error' => true,
                'message' => 'Pocket tidak ditemukan.',
            ], 404);
        }

        $fileName = Str::uuid() . '.xlsx';

        GeneratePocketReportJob::dispatch(
            $pocket->id,
            $data['type'],
            $data['date'],
            $fileName
        )->onQueue('reports');

        return response()->json([
            'status' => 200,
            'error' => false,
            'message' => 'Report sedang dibuat.',
            'data' => [
                'download_url' => url("/reports/{$fileName}")
            ]
        ]);
    }

    public function download(string $file)
    {
        $path = "reports/{$file}";

        if (! Storage::disk('public')->exists($path)) {
            return response()->json([
                'status' => 202,
                'error' => false,
                'message' => 'Report masih diproses.'
            ], 202);
        }

        return Storage::disk('public')->download($path);
    }
}