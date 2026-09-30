<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TenantApprovalController extends Controller
{
    public function index(): View
    {
        $pendingTenants = Tenant::query()
            ->where('status', 'pending')
            ->with('users')
            ->latest()
            ->get();

        return view('admin.tenants.index', compact('pendingTenants'));
    }

    public function approve(Tenant $tenant): RedirectResponse
    {
        abort_unless($tenant->status === 'pending', 422);

        DB::transaction(function () use ($tenant): void {
            $tenant->update(['status' => 'active']);
            $tenant->users()->each(function (User $user) use ($tenant): void {
                $tenant->users()->updateExistingPivot($user->id, ['status' => 'active']);
            });
        });

        return redirect()->route('admin.tenants.index')->with('success', 'Église validée avec succès.');
    }

    public function reject(Tenant $tenant): RedirectResponse
    {
        abort_unless($tenant->status === 'pending', 422);

        DB::transaction(function () use ($tenant): void {
            $tenant->update(['status' => 'rejected']);
            $tenant->users()->each(function (User $user) use ($tenant): void {
                $tenant->users()->updateExistingPivot($user->id, ['status' => 'rejected']);
            });
        });

        return redirect()->route('admin.tenants.index')->with('success', 'Demande refusée.');
    }
}
