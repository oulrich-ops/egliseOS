<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Organisation</p>
                <h2 class="mt-1 text-2xl font-black text-slate-900">Structures de l’église</h2>
                <p class="mt-1 text-sm text-slate-500">Départements, groupes, ministères et équipes.</p>
            </div>
            <a href="{{ route('structures.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white hover:bg-emerald-900">Créer une structure</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
        @endif

        @if ($groups->isEmpty())
            <div class="card-surface border-dashed p-12 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700"><i data-lucide="network" class="h-7 w-7"></i></div>
                <h3 class="mt-5 text-lg font-bold text-slate-900">Votre organisation commence ici</h3>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Créez votre premier département ou groupe, puis affectez-y les membres concernés.</p>
                <a href="{{ route('structures.create') }}" class="mt-6 inline-flex rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-500">Créer la première structure</a>
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($groups as $group)
                    <a href="{{ route('structures.show', $group) }}" class="card-surface block p-5 transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                        <div class="flex items-start justify-between gap-4">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700"><i data-lucide="users-round" class="h-5 w-5"></i></span>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">{{ $group->members_count }} membre(s)</span>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">{{ $group->name }}</h3>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">{{ ucfirst($group->type) }}{{ $group->parent ? ' · ' . $group->parent->name : '' }}</p>
                        <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-600">{{ $group->description ?: 'Aucune description pour le moment.' }}</p>
                        <div class="mt-5 flex items-center gap-1 text-sm font-bold text-emerald-700">Gérer les membres <i data-lucide="arrow-up-right" class="h-4 w-4"></i></div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
