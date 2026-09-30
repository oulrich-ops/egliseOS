<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-emerald-600">Membres</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">Gestion des adhérents</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('members.export') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:border-emerald-300"><i data-lucide="list" class="h-4 w-4 text-emerald-700"></i>Générer une liste</a>
                <a href="{{ route('members.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500"><i data-lucide="user-plus" class="h-4 w-4"></i>Nouveau membre</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-surface overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Nom</th>
                            <th class="px-6 py-3 font-semibold">Téléphone</th>
                            <th class="px-6 py-3 font-semibold">Email</th>
                            <th class="px-6 py-3 font-semibold">Ville</th>
                            <th class="px-6 py-3 font-semibold">Statut</th>
                            <th class="px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($members as $member)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($member->photo_path)
                                            <img src="{{ asset('storage/'.$member->photo_path) }}" alt="Photo de {{ $member->full_name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-xs font-black text-emerald-700">{{ strtoupper(substr($member->first_name, 0, 1).substr($member->last_name, 0, 1)) }}</span>
                                        @endif
                                        <div><div class="font-semibold text-slate-900">{{ $member->full_name ?: $member->first_name . ' ' . $member->last_name }}</div><div class="text-xs text-slate-500">{{ $member->member_number }}</div></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $member->phone ?? '—' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $member->email ?? '—' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $member->city ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        {{ ucfirst($member->status ?? 'active') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('members.show', $member) }}" class="rounded-md border border-emerald-300 px-3 py-1.5 text-xs font-bold text-emerald-700 hover:bg-emerald-50">Dossier</a>
                                        <a href="{{ route('members.edit', $member) }}" class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">Modifier</a>
                                        <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Supprimer ce membre ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md border border-rose-300 px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-50">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500">Aucun membre trouvé pour ce tenant.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $members->links() }}
        </div>
    </div>
</x-app-layout>
