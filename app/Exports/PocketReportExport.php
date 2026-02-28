<?php

namespace App\Exports;

use App\Models\Income;
use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PocketReportExport implements FromArray, WithHeadings
{
    public function __construct(
        private string $pocketId,
        private string $type,
        private string $date
    ) {}

    public function headings(): array
    {
        return ['Amount', 'Notes', 'Created At'];
    }

    public function array(): array
    {
        $query = $this->type === 'INCOME'
            ? Income::where('pocket_id', $this->pocketId)
            : Expense::where('pocket_id', $this->pocketId);

        return $query
            ->whereDate('created_at', $this->date)
            ->get()
            ->map(fn ($row) => [
                $row->amount,
                $row->notes,
                $row->created_at->toDateTimeString()
            ])
            ->toArray();
    }
}