<?php

namespace App\Exports;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PocketReportExport implements FromCollection, WithHeadings
{
    protected string $pocketId;
    protected string $type;
    protected string $date;

    public function __construct(string $pocketId, string $type, string $date)
    {
        $this->pocketId = $pocketId;
        $this->type = $type;
        $this->date = $date;
    }

    public function collection(): Collection
    {
        if ($this->type === 'INCOME') {
            return Income::where('user_pocket_id', $this->pocketId)
                ->whereDate('date', $this->date)
                ->get([
                    'date',
                    'amount',
                    'description'
                ]);
        }

        return Expense::where('user_pocket_id', $this->pocketId)
            ->whereDate('date', $this->date)
            ->get([
                'date',
                'amount',
                'description'
            ]);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jumlah',
            'Deskripsi',
        ];
    }
}