<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();

        $members = Member::query()
            ->when($tenant, fn ($query) => $query->where('tenant_id', $tenant->id))
            ->latest('created_at')
            ->paginate(15);

        return view('members.index', compact('members'));
    }

    public function create(): View
    {
        auth()->user()->tenants()->firstOrFail();

        return view('members.create');
    }

    public function show(Member $member): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        abort_unless($member->tenant_id === $tenant->id, 404);

        $member->load(['groups', 'positions.group', 'memberCards', 'documents']);
        $groups = $tenant->groups()->with('positions')->orderBy('name')->get();

        return view('members.show', compact('member', 'groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = auth()->user()->tenants()->firstOrFail();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'secondary_phone' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:50'],
            'arrival_date' => ['nullable', 'date'],
            'baptized' => ['nullable', 'boolean'],
            'baptism_date' => ['nullable', 'date'],
            'previous_church' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['tenant_id'] = $tenant->id;
        $validated['full_name'] = trim(($validated['first_name'] ?? '').' '.($validated['last_name'] ?? ''));
        $validated['member_number'] = 'MEM-'.strtoupper(substr(md5(uniqid((string) now()->timestamp, true)), 0, 8));

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('members/photos', 'public');
        }

        unset($validated['photo']);

        Member::query()->create($validated);

        return redirect()->route('members.index')->with('success', __('messages.member_created'));
    }

    public function edit(Member $member): View
    {
        abort_unless($member->tenant_id === auth()->user()->tenants()->firstOrFail()->id, 404);

        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        abort_unless($member->tenant_id === auth()->user()->tenants()->firstOrFail()->id, 404);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'secondary_phone' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:50'],
            'arrival_date' => ['nullable', 'date'],
            'baptized' => ['nullable', 'boolean'],
            'baptism_date' => ['nullable', 'date'],
            'previous_church' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['full_name'] = trim(($validated['first_name'] ?? '').' '.($validated['last_name'] ?? ''));

        if ($request->hasFile('photo')) {
            if ($member->photo_path) {
                Storage::disk('public')->delete($member->photo_path);
            }

            $validated['photo_path'] = $request->file('photo')->store('members/photos', 'public');
        }

        unset($validated['photo']);
        $member->update($validated);

        return redirect()->route('members.index')->with('success', __('messages.member_updated'));
    }

    public function destroy(Member $member): RedirectResponse
    {
        abort_unless($member->tenant_id === auth()->user()->tenants()->firstOrFail()->id, 404);

        if ($member->photo_path) {
            Storage::disk('public')->delete($member->photo_path);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', __('messages.member_deleted'));
    }

    public function addEngagement(Request $request, Member $member): RedirectResponse
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        abort_unless($member->tenant_id === $tenant->id, 404);

        $validated = $request->validate([
            'group_id' => ['required', 'integer'],
            'position_id' => ['nullable', 'integer'],
            'started_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $group = $tenant->groups()->findOrFail($validated['group_id']);
        $member->groups()->syncWithoutDetaching([
            $group->id => [
                'joined_at' => $validated['started_at'] ?? now()->toDateString(),
                'status' => 'active',
                'notes' => $validated['notes'] ?? null,
            ],
        ]);

        if (! empty($validated['position_id'])) {
            $position = Position::query()
                ->where('tenant_id', $tenant->id)
                ->where('group_id', $group->id)
                ->findOrFail($validated['position_id']);

            $member->positions()->syncWithoutDetaching([
                $position->id => ['started_at' => $validated['started_at'] ?? now()->toDateString()],
            ]);
        }

        return back()->with('success', __('messages.engagement_added'));
    }
}
