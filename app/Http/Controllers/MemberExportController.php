<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\StreamedResponse;
use Illuminate\View\View;

class MemberExportController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $group = $this->resolveGroup($request, $tenant->id);
        $members = $this->membersQuery($tenant->id, $group?->id)->get();
        $groups = $tenant->groups()->orderBy('name')->get();

        return view('members.export', compact('tenant', 'group', 'groups', 'members'));
    }

    public function csv(Request $request): StreamedResponse
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        $group = $this->resolveGroup($request, $tenant->id);
        $members = $this->membersQuery($tenant->id, $group?->id)->get();
        $filename = 'membres-'.($group ? str($group->slug)->slug() : 'eglise').'-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($members, $group): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nom complet', 'Numéro membre', 'Téléphone', 'Email', 'Ville', 'Statut', 'Structure']);

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->full_name ?: $member->first_name.' '.$member->last_name,
                    $member->member_number,
                    $member->phone,
                    $member->email,
                    $member->city,
                    $member->status,
                    $group?->name ?: 'Toutes les structures',
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function resolveGroup(Request $request, int $tenantId): ?Group
    {
        $groupId = $request->integer('group');

        if (! $groupId) {
            return null;
        }

        return Group::query()
            ->where('tenant_id', $tenantId)
            ->findOrFail($groupId);
    }

    private function membersQuery(int $tenantId, ?int $groupId): Builder
    {
        return Member::query()
            ->where('tenant_id', $tenantId)
            ->when($groupId, fn ($query) => $query->whereHas('groups', fn ($groupsQuery) => $groupsQuery->whereKey($groupId)))
            ->orderBy('last_name')
            ->orderBy('first_name');
    }
}
