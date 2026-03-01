<?php

namespace App\Jobs;

use App\Exports\PocketReportExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GeneratePocketReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $pocketId;
    protected string $type;
    protected string $date;
    protected string $fileName;

    public $timeout = 120;
    public $tries = 3;

    public function __construct(
        string $pocketId,
        string $type,
        string $date,
        string $fileName
    ) {
        $this->pocketId = $pocketId;
        $this->type = $type;
        $this->date = $date;
        $this->fileName = $fileName;
    }

    public function handle(): void
    {
        Storage::disk('public')->makeDirectory('reports');

        Excel::store(
            new PocketReportExport(
                $this->pocketId,
                $this->type,
                $this->date
            ),
            "reports/{$this->fileName}",
            'public'
        );
    }
}