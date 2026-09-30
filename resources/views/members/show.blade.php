<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <a href="{{ route('members.index') }}" class="mb-3 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-900"><i data-lucide="arrow-left" class="h-4 w-4"></i> Membres</a>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Dossier membre</p>
                <h2 class="mt-1 text-2xl font-black text-slate-900">{{ $member->full_name ?: $member->first_name . ' ' . $member->last_name }}</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('members.card', $member) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-bold text-slate-700 hover:border-emerald-300"><i data-lucide="id-card" class="h-4 w-4 text-emerald-700"></i>Carte</a>
                <a href="{{ route('members.edit', $member) }}" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-bold text-white hover:bg-emerald-500"><i data-lucide="pencil" class="h-4 w-4"></i>Modifier</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[0.75fr_1.25fr]">
            <div class="space-y-6">
                <section class="card-surface p-6">
                    <div class="flex items-center gap-4">
                        @if ($member->photo_path)
                            <img src="{{ asset('storage/'.$member->photo_path) }}" alt="Photo de {{ $member->full_name }}" class="h-16 w-16 rounded-2xl object-cover">
                        @else
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#123c35] text-xl font-black text-amber-300">{{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}</div>
                        @endif
                        <div><h3 class="text-lg font-black text-slate-900">{{ $member->member_number }}</h3><span class="mt-1 inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">{{ ucfirst($member->status) }}</span></div>
                    </div>
                    <dl class="mt-6 space-y-4 text-sm"><div><dt class="text-slate-400">Téléphone</dt><dd class="font-semibold text-slate-800">{{ $member->phone ?: 'Non renseigné' }}</dd></div><div><dt class="text-slate-400">Téléphone secondaire</dt><dd class="font-semibold text-slate-800">{{ $member->secondary_phone ?: 'Non renseigné' }}</dd></div><div><dt class="text-slate-400">Email</dt><dd class="font-semibold text-slate-800">{{ $member->email ?: 'Non renseigné' }}</dd></div><div><dt class="text-slate-400">Profession</dt><dd class="font-semibold text-slate-800">{{ $member->profession ?: 'Non renseignée' }}</dd></div><div><dt class="text-slate-400">Naissance</dt><dd class="font-semibold text-slate-800">{{ $member->birth_date?->format('d/m/Y') ?: 'Non renseignée' }}{{ $member->birth_place ? ' · '.$member->birth_place : '' }}</dd></div><div><dt class="text-slate-400">Adresse</dt><dd class="font-semibold text-slate-800">{{ $member->address ?: 'Non renseignée' }}{{ $member->city ? ' · '.$member->city : '' }}</dd></div><div><dt class="text-slate-400">Date d’arrivée</dt><dd class="font-semibold text-slate-800">{{ $member->arrival_date?->format('d/m/Y') ?: 'Non renseignée' }}</dd></div><div><dt class="text-slate-400">Baptême</dt><dd class="font-semibold text-slate-800">{{ $member->baptized ? 'Oui' : 'Non' }}{{ $member->baptism_date ? ' · '.$member->baptism_date->format('d/m/Y') : '' }}</dd></div></dl>
                    @if ($member->previous_church || $member->notes)<div class="mt-6 border-t border-slate-200 pt-5 text-sm">@if ($member->previous_church)<p><span class="text-slate-400">Ancienne église :</span> <span class="font-semibold text-slate-800">{{ $member->previous_church }}</span></p>@endif @if ($member->notes)<p class="mt-3"><span class="text-slate-400">Notes :</span> <span class="font-semibold text-slate-800">{{ $member->notes }}</span></p>@endif</div>@endif
                </section>

                <section class="card-surface p-6">
                    <div class="flex items-center justify-between"><h3 class="text-lg font-black text-slate-900">Documents</h3><a href="{{ route('members.card', $member) }}" class="text-sm font-bold text-emerald-700">Carte membre</a></div>
                    <form action="{{ route('members.recommendation', $member) }}" method="POST" class="mt-4 space-y-3">@csrf<input name="purpose" placeholder="Objet de la recommandation (optionnel)" class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm"><button class="inline-flex items-center gap-2 rounded-lg bg-[#123c35] px-3 py-2 text-sm font-bold text-white hover:bg-emerald-900"><i data-lucide="file-plus-2" class="h-4 w-4"></i>Générer une recommandation</button></form>
                    <div class="mt-5 space-y-2">@forelse ($member->documents as $document)<a href="{{ route('member-documents.show', $document) }}" class="flex items-center justify-between rounded-lg border border-slate-200 p-3 text-sm hover:border-emerald-300"><span class="font-semibold text-slate-800">{{ $document->title }}</span><span class="text-xs text-slate-500">{{ $document->reference }}</span></a>@empty<p class="text-sm text-slate-500">Aucun document généré.</p>@endforelse</div>
                </section>
            </div>

            <div class="space-y-6">
                <section class="card-surface p-6">
                    <div class="flex items-center justify-between"><div><h3 class="text-lg font-black text-slate-900">Parcours dans l’église</h3><p class="mt-1 text-sm text-slate-500">Chorale, accueil, jeunesse, service ou responsabilité.</p></div><i data-lucide="history" class="h-6 w-6 text-emerald-700"></i></div>
                    <div class="mt-5 space-y-3">@forelse ($member->groups as $group)<div class="flex items-center justify-between rounded-xl border border-slate-200 p-4"><div><p class="font-bold text-slate-800">{{ $group->name }}</p><p class="mt-1 text-xs text-slate-500">Depuis {{ $group->pivot->joined_at ? \Carbon\Carbon::parse($group->pivot->joined_at)->format('d/m/Y') : 'date non renseignée' }}</p></div><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ ucfirst($group->pivot->status) }}</span></div>@empty<p class="text-sm text-slate-500">Aucun engagement enregistré.</p>@endforelse</div>
                    @if ($member->positions->isNotEmpty())<div class="mt-5 border-t border-slate-200 pt-5"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Fonctions exercées</p><div class="mt-3 flex flex-wrap gap-2">@foreach ($member->positions as $position)<span class="rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-800">{{ $position->name }} · {{ $position->group->name }}</span>@endforeach</div></div>@endif
                </section>

                <section class="card-surface p-6"><h3 class="text-lg font-black text-slate-900">Ajouter un engagement</h3><form action="{{ route('members.engagements.store', $member) }}" method="POST" class="mt-5 grid gap-4 sm:grid-cols-2">@csrf<div><label for="group_id" class="mb-1.5 block text-sm font-bold text-slate-700">Structure</label><select id="group_id" name="group_id" class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required><option value="">Sélectionner</option>@foreach ($groups as $group)<option value="{{ $group->id }}">{{ $group->name }}</option>@endforeach</select></div><div><label for="position_id" class="mb-1.5 block text-sm font-bold text-slate-700">Fonction</label><select id="position_id" name="position_id" class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm"><option value="">Aucune fonction</option>@foreach ($groups as $group)@foreach ($group->positions as $position)<option value="{{ $position->id }}">{{ $position->name }} · {{ $group->name }}</option>@endforeach @endforeach</select></div><div><label for="started_at" class="mb-1.5 block text-sm font-bold text-slate-700">Depuis le</label><input id="started_at" type="date" name="started_at" class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm"></div><div><label for="notes" class="mb-1.5 block text-sm font-bold text-slate-700">Notes</label><input id="notes" name="notes" placeholder="Ex. Service dominical" class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm"></div><button class="sm:col-span-2 inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-500"><i data-lucide="plus" class="h-4 w-4"></i>Enregistrer l’engagement</button></form></section>
            </div>
        </div>
    </div>
</x-app-layout>
