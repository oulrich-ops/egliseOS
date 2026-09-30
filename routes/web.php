<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDocumentController;
use App\Http\Controllers\MemberExportController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantApprovalController;
use App\Http\Controllers\TenantUserController;
use Illuminate\Support\Facades\Route;

Route::get('/verify-card/{token}', [MemberDocumentController::class, 'verifyCard'])->name('cards.verify');
Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');

Route::middleware('auth')->group(function () {
    Route::get('/demande-en-attente', function () {
        $tenant = auth()->user()->tenants()->latest('tenants.created_at')->first();

        return view('tenant.pending', compact('tenant'));
    })->name('tenant.pending');
});

Route::middleware(['auth', 'verified', 'platform-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/tenants', [TenantApprovalController::class, 'index'])->name('tenants.index');
        Route::patch('/tenants/{tenant}/approve', [TenantApprovalController::class, 'approve'])->name('tenants.approve');
        Route::patch('/tenants/{tenant}/reject', [TenantApprovalController::class, 'reject'])->name('tenants.reject');
    });

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'tenant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('members', MemberController::class)->except(['show']);
    Route::get('/members/export', [MemberExportController::class, 'index'])->name('members.export');
    Route::get('/members/export.csv', [MemberExportController::class, 'csv'])->name('members.export.csv');
    Route::get('/members/{member}/dossier', [MemberController::class, 'show'])->name('members.show');
    Route::post('/members/{member}/engagements', [MemberController::class, 'addEngagement'])->name('members.engagements.store');
    Route::get('/members/{member}/card', [MemberDocumentController::class, 'card'])->name('members.card');
    Route::post('/members/{member}/recommendation', [MemberDocumentController::class, 'recommendation'])->name('members.recommendation');
    Route::get('/member-documents/{document}', [MemberDocumentController::class, 'show'])->name('member-documents.show');
    Route::resource('structures', GroupController::class)->only(['index', 'create', 'store', 'show'])->parameters(['structures' => 'group']);
    Route::put('/structures/{group}/members', [GroupController::class, 'syncMembers'])->name('structures.members.sync');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::resource('positions', PositionController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('users', TenantUserController::class)->only(['index', 'create', 'store', 'destroy']);
    });
});

require __DIR__.'/auth.php';
