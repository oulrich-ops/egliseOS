<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <a href="{{ route('structures.index') }}" class="mb-3 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-900"><i data-lucide="arrow-left" class="h-4 w-4"></i> Structures</a>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">{{ ucfirst($group->type) }}</p>
                <h2 class="mt-1 text-2xl font-black text-slate-900">{{ $group->name }}</h2>
            </div>
            <div class="flex flex-wrap items-center gap-2 self-start"><a href="{{ route('members.export', ['group' => $group->id]) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-bold text-slate-700 hover:border-emerald-300"><i data-lucide="list" class="h-4 w-4 text-emerald-700"></i>Liste de la structure</a><span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1.5 text-sm font-bold text-emerald-700"><i data-lucide="users-round" class="h-4 w-4"></i>{{ $group->members->count() }} membre(s)</span></div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
            <div class="card-surface p-6">
                <h3 class="text-lg font-bold text-slate-900">À propos</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $group->description ?: 'Cette structure n’a pas encore de description.' }}</p>
                @if ($group->parent)
                    <div class="mt-6 border-t border-slate-200 pt-5"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Structure parente</p><p class="mt-1 font-semibold text-slate-800">{{ $group->parent->name }}</p></div>
                @endif
            </div>

            <div class="card-surface p-6">
                <div class="mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Affecter les membres</h3>
                    <p class="mt-1 text-sm text-slate-500">Sélectionnez les membres qui appartiennent à cette structure.</p>
                </div>
                <form action="{{ route('structures.members.sync', $group) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($members->isEmpty())
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500">Ajoutez d’abord des membres depuis le menu Membres.</div>
                    @else
                        <div class="max-h-96 space-y-2 overflow-y-auto pr-1">
                            @foreach ($members as $member)
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 transition hover:border-emerald-300 hover:bg-emerald-50/40">
                                    <input type="checkbox" name="member_ids[]" value="{{ $member->id }}" @checked($group->members->contains($member->id)) class="h-4 w-4 rounded border-slate-400 text-emerald-700 focus:ring-emerald-600">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-xs font-black text-slate-600">{{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}</span>
                                    <span class="min-w-0 flex-1"><span class="block truncate text-sm font-bold text-slate-800">{{ $member->full_name ?: $member->first_name . ' ' . $member->last_name }}</span><span class="block text-xs text-slate-500">{{ $member->phone ?: 'Téléphone non renseigné' }}</span></span>
                                </label>
                            @endforeach
                        </div>
                        <button type="submit" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#123c35] px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-900"><i data-lucide="save" class="h-4 w-4"></i>Enregistrer les affectations</button>
                    @endif
                </form>
            </div>
        </div>

        <div class="card-surface mt-6 p-6">
            <h3 class="text-lg font-bold text-slate-900">Membres affectés</h3>
            @if ($group->members->isEmpty())
                <p class="mt-3 text-sm text-slate-500">Aucun membre n’est encore affecté à cette structure.</p>
            @else
                <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($group->members as $member)
                        <div class="rounded-xl border border-slate-200 p-3"><p class="font-semibold text-slate-800">{{ $member->full_name ?: $member->first_name . ' ' . $member->last_name }}</p><p class="mt-1 text-xs text-slate-500">{{ $member->member_number }}</p></div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
