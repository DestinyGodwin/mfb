<?php

use App\Models\Contribution;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\ProfitRateController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\InterestRateController;
use App\Http\Controllers\Admin\ProfitDistributionController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\ContributionController as AdminContributionController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $year = now()->year;

    $yearlyContribution = Contribution::where('user_id', auth()->id())
        ->whereYear('contribution_date', $year)
        ->sum('amount');

    return view('dashboard', compact('year', 'yearlyContribution'));
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/bank-account', [ProfileController::class, 'updateBankAccount'])->name('profile.bank-account');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Contributions
    Route::get('/contributions', [ContributionController::class, 'index'])->name('contributions.index');

    // Loans
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
});

/*
|--------------------------------------------------------------------------
| Admin & Finance Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin|finance'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Loans
        Route::get('/loans', [AdminLoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/create', [AdminLoanController::class, 'create'])->name('loans.create');
        Route::post('/loans', [AdminLoanController::class, 'store'])->name('loans.store');
        Route::post('/loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');

        // Contributions
        Route::get('/contributions', [AdminContributionController::class, 'index'])->name('contributions.index');
        Route::get('/contributions/create', [AdminContributionController::class, 'create'])->name('contributions.create');
        Route::post('/contributions', [AdminContributionController::class, 'store'])->name('contributions.store');
        Route::get('/contributions/export/excel', [AdminContributionController::class, 'exportExcel'])->name('contributions.export.excel');
        Route::get('/contributions/export/pdf', [AdminContributionController::class, 'exportPdf'])->name('contributions.export.pdf');

        // Interest Rates
        Route::get('/interest-rates', [InterestRateController::class, 'index'])->name('interest-rates.index');
        Route::post('/interest-rates', [InterestRateController::class, 'store'])->name('interest-rates.store');

        // Bank Accounts
        Route::get('/bank-accounts', [BankAccountController::class, 'index'])->name('bank-accounts.index');
        Route::get('/bank-accounts/export/excel', [BankAccountController::class, 'exportExcel'])->name('bank-accounts.export.excel');
        Route::get('/bank-accounts/export/pdf', [BankAccountController::class, 'exportPdf'])->name('bank-accounts.export.pdf');
    });

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        // Members
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::get('/members/{user}', [MemberController::class, 'show'])->name('members.show');
        Route::post('/members/{user}/approve', [MemberController::class, 'approve'])->name('members.approve');
        Route::patch('/members/{user}/status', [MemberController::class, 'updateStatus'])->name('members.status');
    });
Route::prefix('admin')
    ->middleware(['auth', 'role:admin|finance'])
    ->name('admin.')
    ->group(function () {

        Route::get('/profits', [ProfitDistributionController::class, 'index'])
            ->name('profits.index');

        Route::post('/profits/distribute', [ProfitDistributionController::class, 'distribute'])
            ->name('profits.distribute');
    });

Route::prefix('admin')
    ->middleware(['auth', 'role:admin|finance'])
    ->name('admin.')
    ->group(function () {

        Route::get('/profit-rates', [ProfitRateController::class, 'index'])
            ->name('profit-rates.index');

        Route::post('/profit-rates', [ProfitRateController::class, 'store'])
            ->name('profit-rates.store');

        Route::post('/profit-rates/{profitRate}/activate', [ProfitRateController::class, 'activate'])
            ->name('profit-rates.activate');
    });


require __DIR__.'/auth.php';
