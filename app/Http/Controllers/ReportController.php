<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePocketReportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function create(Request $request, string $id)
    {
        $data = $request->validate([
            'type' => 'required|in:INCOME,EXPENSE',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $fileName = Str::uuid() . '-' . time() . '.xlsx';

        GeneratePocketReportJob::dispatch(
            $id,
            $data['type'],
            $data['date'],
            $fileName
        );

        return response()->json([
            'status' => 200,
            'error' => false,
            'message' => 'Report sedang dibuat. Silahkan check berkala pada link berikut.',
            'data' => [
                'link' => url("/reports/{$fileName}")
            ]
        ]);
    }

    public function download(string $file)
    {
        $path = storage_path("app/reports/{$file}");

        abort_if(!file_exists($path), 404);

        return response()->download($path);
    }
}