<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Paramètres</p>
                <h2 class="mt-1 text-2xl font-black text-slate-900">Fonctions et responsabilités</h2>
                <p class="mt-1 text-sm text-slate-500">Créez les fonctions que vous pourrez ensuite affecter aux membres.</p>
            </div>
            <a href="{{ route('settings.positions.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white hover:bg-emerald-900"><i data-lucide="plus" class="h-4 w-4"></i>Ajouter une fonction</a>
            <a href="{{ route('settings.users.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:border-emerald-300"><i data-lucide="users-round" class="h-4 w-4 text-emerald-700"></i>Utilisateurs</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>@endif
        @if ($groups->isEmpty())
            <div class="card-surface border-dashed p-12 text-center"><i data-lucide="settings-2" class="mx-auto h-8 w-8 text-emerald-700"></i><h3 class="mt-4 text-lg font-bold">Créez d’abord une structure</h3><p class="mt-2 text-sm text-slate-500">Les fonctions sont toujours rattachées à un département, groupe ou ministère.</p><a href="{{ route('structures.create') }}" class="mt-5 inline-flex rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white">Créer une structure</a></div>
        @else
            <div class="space-y-5">
                @foreach ($groups as $group)
                    <section class="card-surface overflow-hidden"><div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-5 py-4"><div><h3 class="font-black text-slate-900">{{ $group->name }}</h3><p class="mt-1 text-xs uppercase tracking-wider text-slate-400">{{ $group->positions->count() }} fonction(s)</p></div><a href="{{ route('structures.show', $group) }}" class="text-sm font-bold text-emerald-700">Voir la structure</a></div><div class="divide-y divide-slate-200">@forelse ($group->positions as $position)<div class="flex items-center justify-between gap-4 px-5 py-4"><div><p class="font-semibold text-slate-800">{{ $position->name }}</p><p class="mt-1 text-sm text-slate-500">{{ $position->description ?: 'Aucune description' }}</p></div><form action="{{ route('settings.positions.destroy', $position) }}" method="POST" onsubmit="return confirm('Supprimer cette fonction ?');">@csrf @method('DELETE')<button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-bold text-rose-700 hover:bg-rose-50">Supprimer</button></form></div>@empty<p class="px-5 py-6 text-sm text-slate-500">Aucune fonction définie pour cette structure.</p>@endforelse</div></section>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
