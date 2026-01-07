<?php

use Illuminate\Support\Facades\Route;
use App\Models\Contribution;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\InterestRateController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\MemberController;
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
| Authenticated User
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Contributions (read-only)
    Route::get('/contributions', [ContributionController::class, 'index'])
        ->name('contributions.index');

    // User Loans
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
});

/*
|--------------------------------------------------------------------------
| Admin & Finance
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin|finance'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Members
        Route::get('/members', [MemberController::class, 'index'])
            ->name('members.index');

        // Loans
        Route::get('/loans', [AdminLoanController::class, 'index'])
            ->name('loans.index');
        Route::get('/loans/create', [AdminLoanController::class, 'create'])
            ->name('loans.create');
        Route::post('/loans', [AdminLoanController::class, 'store'])
            ->name('loans.store');
        Route::post('/loans/{loan}/approve', [AdminLoanController::class, 'approve'])
            ->name('loans.approve');

        // Contributions
        Route::get('/contributions', [AdminContributionController::class, 'index'])
            ->name('contributions.index');
        Route::get('/contributions/create', [AdminContributionController::class, 'create'])
            ->name('contributions.create');
        Route::post('/contributions', [AdminContributionController::class, 'store'])
            ->name('contributions.store');

        // Interest Rates
        Route::get('/interest-rates', [InterestRateController::class, 'index'])
            ->name('interest-rates.index');
    });

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/members/pending', [MemberController::class, 'pending'])
            ->name('members.pending');

        Route::post('/members/{user}/approve', [MemberController::class, 'approve'])
            ->name('members.approve');

        Route::post('/members/{user}/reject', [MemberController::class, 'reject'])
            ->name('members.reject');
    });

require __DIR__.'/auth.php';
