<?php

use App\Models\Contribution;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\InterestRateController;
use App\Http\Controllers\Admin\LoanApprovalController;
use App\Http\Controllers\Admin\MemberApprovalController;
use App\Http\Controllers\Admin\ContributionController as AdminContributionController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $year = now()->year;

    $yearlyContribution = Contribution::where('user_id', auth()->id())
        ->whereYear('contribution_date', $year)
        ->sum('amount');

    return view('dashboard', compact('year', 'yearlyContribution'));
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Contributions (VIEW ONLY)
    Route::get('/contributions', [ContributionController::class, 'index'])
        ->name('contributions.index');

    // Loans
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    
});

/*
|--------------------------------------------------------------------------
| Admin / Finance
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin|finance'])
    ->group(function () {

        // Contributions
        Route::get('/contributions/create', [AdminContributionController::class, 'create']);
        Route::post('/contributions', [AdminContributionController::class, 'store']);

        // Loan approvals
        Route::post('/loans/{loan}/approve', [LoanApprovalController::class, 'approve']);
    });

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/members/pending', [MemberApprovalController::class,'index']);
        Route::post('/members/{user}/approve', [MemberApprovalController::class,'approve']);
        Route::post('/members/{user}/reject', [MemberApprovalController::class,'reject']);
    });
Route::prefix('admin')
    ->middleware(['auth', 'role:admin|finance'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
    });


    Route::prefix('admin')
    ->middleware(['auth', 'role:admin|finance'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Interest Rates
        Route::get('/interest-rates', [InterestRateController::class, 'index'])->name('interest-rates.index');
        Route::post('/interest-rates', [InterestRateController::class, 'store']);

        // Contributions
        Route::get('/contributions/create', [AdminContributionController::class, 'create'])->name('contributions.create');
        Route::post('/contributions', [AdminContributionController::class, 'store']);

        // Loans
        Route::get('/loans/pending', [LoanApprovalController::class, 'index'])->name('loans.pending');
        Route::post('/loans/{loan}/approve', [LoanApprovalController::class, 'approve'])->name('loans.approve');
    });

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/members/pending', [MemberApprovalController::class,'index'])->name('members.pending');
        Route::post('/members/{user}/approve', [MemberApprovalController::class,'approve'])->name('members.approve');
        Route::post('/members/{user}/reject', [MemberApprovalController::class,'reject'])->name('members.reject');
    });

require __DIR__.'/auth.php';
