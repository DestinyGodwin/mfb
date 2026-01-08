<?php

namespace App\Exports;

use App\Models\BankAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankAccountsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BankAccount::with('user')->get()->map(function ($a) {
            return [
                'Name'           => $a->user->first_name.' '.$a->user->last_name,
                'Email'          => $a->user->email,
                'Phone'          => $a->user->phone,
                'Bank Name'      => $a->bank_name,
                'Account Number' => $a->account_number,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Bank Name',
            'Account Number',
        ];
    }
}
