<?php

namespace App\Exports;

use App\Models\ProfitDistribution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfitDistributionsExport implements FromCollection, WithHeadings
{
    public function __construct(private int $year) {}

    public function collection()
    {
        return ProfitDistribution::with('user')
            ->where('year', $this->year)
            ->get()
            ->map(fn ($p) => [
                'Member' => $p->user->first_name.' '.$p->user->last_name,
                'Total Contribution' => $p->total_contribution,
                'Profit Amount' => $p->profit_amount,
                'Distributed At' => optional($p->distributed_at)->format('Y-m-d'),
            ]);
    }

    public function headings(): array
    {
        return [
            'Member',
            'Total Contribution',
            'Profit Amount',
            'Distributed At',
        ];
    }
}
