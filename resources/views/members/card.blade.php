<!DOCTYPE html>
<html lang="fr">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Carte de membre - {{ $member->full_name }}</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-slate-100 p-6 text-slate-900 sm:p-12">
    <main class="mx-auto max-w-2xl">
        <div class="mb-6 flex items-center justify-between print:hidden"><a href="{{ route('members.show', $member) }}" class="text-sm font-bold text-emerald-700">Retour au dossier</a><button onclick="window.print()" class="rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white">Imprimer / PDF</button></div>
        <section class="overflow-hidden rounded-3xl bg-[#123c35] text-white shadow-xl print:shadow-none">
            <div class="flex items-start justify-between border-b border-white/15 p-7"><div><p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-300">Carte officielle</p><h1 class="mt-2 text-2xl font-black">{{ $tenant->name }}</h1><p class="mt-1 text-xs text-emerald-50/60">Carte d’identification ecclésiale</p></div><span class="flex h-14 w-14 items-center justify-center rounded-2xl border border-amber-200/40 bg-amber-300 text-[#123c35]"><i data-lucide="church" class="h-7 w-7"></i></span></div>
            <div class="grid gap-8 p-7 sm:grid-cols-[1fr_auto] sm:items-center"><div class="flex items-center gap-4"><div>@if ($member->photo_path)<img src="{{ asset('storage/'.$member->photo_path) }}" alt="Photo de {{ $member->full_name }}" class="h-20 w-20 rounded-2xl object-cover ring-2 ring-white/20">@else<div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/10 text-xl font-black text-amber-300">{{ strtoupper(substr($member->first_name, 0, 1).substr($member->last_name, 0, 1)) }}</div>@endif</div><div><p class="text-xs uppercase tracking-widest text-emerald-100/60">Membre</p><h2 class="mt-2 text-3xl font-black">{{ $member->full_name }}</h2><p class="mt-3 text-sm text-emerald-50/70">N° {{ $card->card_number }}</p><p class="mt-1 text-sm text-emerald-50/70">Valide jusqu’au {{ $card->expires_at?->format('d/m/Y') }}</p></div></div><div class="rounded-2xl bg-white p-2"><canvas id="member-card-qr" data-qr-value="{{ route('cards.verify', $card->verification_token) }}" width="128" height="128" class="h-28 w-28"></canvas><p class="mt-1 text-center text-[9px] font-bold uppercase tracking-wide text-[#123c35]">Scanner pour vérifier</p></div></div>
            <div class="bg-amber-300 px-7 py-3 text-xs font-bold uppercase tracking-widest text-[#123c35]">{{ ucfirst($member->status) }} · {{ $member->member_number }}</div>
        </section>
    </main>
</body>
</html>
