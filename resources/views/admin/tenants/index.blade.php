<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-emerald-600">Administration</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-900">Demandes d’églises</h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="space-y-4">
            @forelse ($pendingTenants as $tenant)
                @php($owner = $tenant->users->first())
                <article class="card-surface flex flex-col gap-5 p-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $tenant->name }}</h3>
                        <p class="mt-1 text-sm text-slate-500">Demande créée le {{ $tenant->created_at->format('d/m/Y à H:i') }}</p>
                        @if ($owner)
                            <p class="mt-3 text-sm text-slate-700"><span class="font-semibold">Responsable :</span> {{ $owner->name }} — {{ $owner->email }}</p>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('admin.tenants.reject', $tenant) }}" onsubmit="return confirm('Refuser cette demande ?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-lg border border-rose-300 px-4 py-2 text-sm font-bold text-rose-700 hover:bg-rose-50">Refuser</button>
                        </form>
                        <form method="POST" action="{{ route('admin.tenants.approve', $tenant) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-500">Valider</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="card-surface p-8 text-center text-sm text-slate-500">Aucune demande en attente.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
