<?php

namespace App\Jobs;

use App\Exports\PocketReportExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GeneratePocketReportJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        private string $pocketId,
        private string $type,
        private string $date,
        private string $fileName
    ) {}

    public function handle(): void
    {
        Excel::store(
            new PocketReportExport(
                $this->pocketId,
                $this->type,
                $this->date
            ),
            "reports/{$this->fileName}"
        );
    }
}