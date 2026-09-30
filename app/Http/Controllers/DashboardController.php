<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenant = auth()->user()?->tenants()->first();

        $membersCount = Member::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id))
            ->count();

        $activeMembersCount = Member::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id))
            ->where('status', 'active')
            ->count();

        $groupsCount = Group::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id))
            ->count();

        $recentMembers = Member::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id))
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('dashboard', compact('membersCount', 'activeMembersCount', 'groupsCount', 'recentMembers'));
    }
}
