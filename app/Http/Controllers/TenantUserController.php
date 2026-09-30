<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TenantUserController extends Controller
{
    public function index(): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $this->ensureCanManageUsers($tenant->id);
        $users = $tenant->users()->orderBy('name')->get();

        return view('settings.users.index', compact('tenant', 'users'));
    }

    public function create(): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $this->ensureCanManageUsers($tenant->id);

        return view('settings.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $this->ensureCanManageUsers($tenant->id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,manager,member'],
        ]);

        $user = User::query()->firstOrCreate(
            ['email' => $validated['email']],
            ['name' => $validated['name'], 'password' => Hash::make($validated['password'])]
        );

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        $tenant->users()->syncWithoutDetaching([
            $user->id => ['role' => $validated['role'], 'status' => 'active'],
        ]);

        return redirect()->route('settings.users.index')->with('success', __('messages.user_added'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $this->ensureCanManageUsers($tenant->id);
        abort_if($user->is(auth()->user()), 422, __('messages.cannot_remove_self'));

        $tenant->users()->detach($user->id);

        return back()->with('success', __('messages.user_removed'));
    }

    private function ensureCanManageUsers(int $tenantId): void
    {
        $role = auth()->user()->tenants()->whereKey($tenantId)->firstOrFail()->pivot->role;
        abort_unless(in_array($role, ['super_admin', 'admin'], true), 403);
    }
}
