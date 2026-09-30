<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function index(): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $groups = $tenant->groups()->withCount('members')->with('parent')->latest()->get();

        return view('groups.index', compact('groups'));
    }

    public function create(): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $parents = $tenant->groups()->orderBy('name')->get();

        return view('groups.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer'],
        ]);

        if (! empty($validated['parent_id'])) {
            abort_unless($tenant->groups()->whereKey($validated['parent_id'])->exists(), 422);
        }

        $group = $tenant->groups()->create([
            ...$validated,
            'slug' => Str::slug($validated['name']).'-'.Str::lower(Str::random(5)),
            'status' => 'active',
        ]);

        return redirect()->route('structures.show', $group)->with('success', __('messages.structure_created'));
    }

    public function show(Group $group): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        abort_unless($group->tenant_id === $tenant->id, 404);

        $group->load('members');
        $members = $tenant->members()->orderBy('last_name')->orderBy('first_name')->get();

        return view('groups.show', compact('group', 'members'));
    }

    public function syncMembers(Request $request, Group $group): RedirectResponse
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        abort_unless($group->tenant_id === $tenant->id, 404);

        $validated = $request->validate([
            'member_ids' => ['nullable', 'array'],
            'member_ids.*' => ['integer'],
        ]);

        $memberIds = $tenant->members()->whereIn('id', $validated['member_ids'] ?? [])->pluck('id');
        $group->members()->sync($memberIds->mapWithKeys(fn ($id) => [
            $id => ['joined_at' => now()->toDateString(), 'status' => 'active'],
        ])->all());

        return back()->with('success', __('messages.structure_members_updated'));
    }
}
