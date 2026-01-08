<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BankAccountsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.bank_accounts.index', compact('accounts'));
    }

    public function exportExcel()
    {
        return Excel::download(
            new BankAccountsExport,
            'bank-accounts.xlsx'
        );
    }

    public function exportPdf()
    {
        $accounts = BankAccount::with('user')->get();

        $pdf = Pdf::loadView('admin.bank_accounts.pdf', compact('accounts'));

        return $pdf->download('bank-accounts.pdf');
    }
}
