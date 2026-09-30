<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberCard;
use App\Models\MemberDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MemberDocumentController extends Controller
{
    public function card(Member $member): View
    {
        $this->ensureMemberBelongsToCurrentTenant($member);
        $tenant = auth()->user()->tenants()->firstOrFail();
        $card = $member->memberCards()->latest()->first();

        if (! $card) {
            $card = MemberCard::create([
                'tenant_id' => $tenant->id,
                'member_id' => $member->id,
                'card_number' => 'CARD-'.strtoupper(Str::random(10)),
                'verification_token' => Str::random(40),
                'status' => 'active',
                'expires_at' => now()->addYear(),
            ]);
        }

        return view('members.card', compact('member', 'tenant', 'card'));
    }

    public function recommendation(Request $request, Member $member): View
    {
        $this->ensureMemberBelongsToCurrentTenant($member);
        $tenant = auth()->user()->tenants()->firstOrFail();
        $request->validate(['purpose' => ['nullable', 'string', 'max:255']]);

        $document = MemberDocument::create([
            'tenant_id' => $tenant->id,
            'member_id' => $member->id,
            'type' => 'recommendation',
            'title' => 'Lettre de recommandation',
            'reference' => 'LR-'.strtoupper(Str::random(10)),
            'issued_at' => now(),
            'metadata' => ['purpose' => $request->input('purpose')],
        ]);

        return view('members.recommendation', compact('member', 'tenant', 'document'));
    }

    public function show(MemberDocument $document): View
    {
        $tenant = auth()->user()->tenants()->firstOrFail();
        abort_unless($document->tenant_id === $tenant->id, 404);
        $document->load('member', 'tenant');

        return view('members.document', compact('document'));
    }

    public function verifyCard(string $token): View
    {
        $card = MemberCard::query()
            ->where('verification_token', $token)
            ->with(['member', 'tenant'])
            ->firstOrFail();
        $isValid = $card->status === 'active' && (! $card->expires_at || ! $card->expires_at->isPast());

        return view('members.verify-card', compact('card', 'isValid'));
    }

    private function ensureMemberBelongsToCurrentTenant(Member $member): void
    {
        abort_unless($member->tenant_id === auth()->user()->tenants()->firstOrFail()->id, 404);
    }
}
