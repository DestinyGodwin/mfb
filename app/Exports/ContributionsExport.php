<?php

namespace App\Exports;

use App\Models\Contribution;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContributionsExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Contribution::with(['member', 'recorder'])->latest('contribution_date');

        if ($this->request->filled(['from', 'to'])) {
            $query->whereBetween('contribution_date', [
                $this->request->from,
                $this->request->to,
            ]);
        }

        if ($this->request->filled('user_ids')) {
            $query->whereIn('user_id', $this->request->user_ids);
        }

        return $query->get()->map(fn ($c) => [
            'Date' => $c->contribution_date->format('Y-m-d'),
            'Member' => $c->member->first_name . ' ' . $c->member->last_name,
            'Amount' => $c->amount,
            'Recorded By' => $c->recorder?->first_name ?? '-',
        ]);
    }

    public function headings(): array
    {
        return ['Date', 'Member', 'Amount', 'Recorded By'];
    }
}