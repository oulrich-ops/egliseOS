<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-emerald-600">Tableau de bord</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">Vue d'ensemble de l'église</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('structures.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-sm hover:border-emerald-300 hover:bg-emerald-50"><i data-lucide="network" class="h-4 w-4 text-emerald-700"></i>Créer une structure</a>
                <a href="{{ route('members.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-500"><i data-lucide="user-plus" class="h-4 w-4"></i>Ajouter un membre</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="card-surface p-5">
                <p class="text-sm font-medium text-slate-500">Total membres</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $membersCount }}</p>
            </div>
            <div class="card-surface p-5">
                <p class="text-sm font-medium text-slate-500">Membres actifs</p>
                <p class="mt-3 text-3xl font-bold text-emerald-600">{{ $activeMembersCount }}</p>
            </div>
            <div class="card-surface p-5">
                <p class="text-sm font-medium text-slate-500">Groupes</p>
                <p class="mt-3 text-3xl font-bold text-sky-600">{{ $groupsCount }}</p>
                <a href="{{ route('structures.index') }}" class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-sky-700 hover:text-sky-900">Gérer les structures <i data-lucide="arrow-up-right" class="h-4 w-4"></i></a>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1.4fr_0.9fr]">
            <div class="card-surface p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900">Derniers membres</h3>
                    <a href="{{ route('members.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">Voir tout</a>
                </div>

                <div class="space-y-4">
                    @forelse ($recentMembers as $member)
                        <div class="flex items-center justify-between rounded-xl border border-slate-200 p-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $member->full_name ?: $member->first_name . ' ' . $member->last_name }}</p>
                                <p class="text-sm text-slate-500">{{ $member->city ?? 'Ville non renseignée' }}</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">{{ ucfirst($member->status ?? 'active') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Aucun membre pour le moment.</p>
                    @endforelse
                </div>
            </div>

            <div class="card-surface p-6">
                    <h3 class="text-lg font-semibold text-slate-900">Votre espace commence ici</h3>
                <ul class="mt-4 space-y-4 text-sm text-slate-600">
                    <li class="flex items-start gap-3 rounded-lg bg-slate-50 p-3"><i data-lucide="user-plus" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-700"></i><span>Ajoutez vos premiers membres.</span></li>
                    <li class="flex items-start gap-3 rounded-lg bg-slate-50 p-3"><i data-lucide="network" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-700"></i><span>Créez les départements et groupes de votre église.</span></li>
                    <li class="flex items-start gap-3 rounded-lg bg-slate-50 p-3"><i data-lucide="users-round" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-700"></i><span>Affectez les membres aux bonnes structures.</span></li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
