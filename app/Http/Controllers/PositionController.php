<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PositionController extends Controller
{
    public function index(): View
    {
        //
        $tenant = auth()->user()->tenants()->firstOrFail();
        $groups = $tenant->groups()->with(['positions' => fn ($query) => $query->orderBy('sort_order')->orderBy('name')])->orderBy('name')->get();

        return view('settings.positions.index', compact('groups'));
    }

    public function create(): View
    {
        //
        $tenant = auth()->user()->tenants()->firstOrFail();
        $groups = $tenant->groups()->orderBy('name')->get();

        return view('settings.positions.create', compact('groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        //
        $tenant = auth()->user()->tenants()->firstOrFail();
        $validated = $request->validate([
            'group_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $tenant->groups()->findOrFail($validated['group_id']);
        Position::create([
            ...$validated,
            'tenant_id' => $tenant->id,
            'status' => 'active',
        ]);

        return redirect()->route('settings.positions.index')->with('success', __('messages.position_created'));
    }

    public function destroy(string $id): RedirectResponse
    {
        //
        $tenant = auth()->user()->tenants()->firstOrFail();
        $position = $tenant->positions()->findOrFail($id);
        $position->delete();

        return redirect()->route('settings.positions.index')->with('success', __('messages.position_deleted'));
    }
}
