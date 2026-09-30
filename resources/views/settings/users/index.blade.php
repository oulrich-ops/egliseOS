<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Paramètres</p>
                <h2 class="mt-1 text-2xl font-black text-slate-900">Utilisateurs de l’église</h2>
                <p class="mt-1 text-sm text-slate-500">Ajoutez votre équipe à {{ $tenant->name }} sans créer un nouvel espace.</p>
            </div>
            <a href="{{ route('settings.users.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white hover:bg-emerald-900"><i data-lucide="user-plus" class="h-4 w-4"></i>Ajouter un utilisateur</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>@endif
        <div class="card-surface overflow-hidden"><div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-200 text-left text-sm"><thead class="bg-slate-50"><tr><th class="px-6 py-3 font-bold">Utilisateur</th><th class="px-6 py-3 font-bold">Rôle</th><th class="px-6 py-3 font-bold">Accès</th><th class="px-6 py-3 text-right font-bold">Action</th></tr></thead><tbody class="divide-y divide-slate-200 bg-white">@foreach ($users as $user)<tr><td class="px-6 py-4"><p class="font-bold text-slate-900">{{ $user->name }}</p><p class="mt-1 text-xs text-slate-500">{{ $user->email }}</p></td><td class="px-6 py-4"><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700">{{ match($user->pivot->role) { 'super_admin' => 'Propriétaire', 'admin' => 'Administrateur', 'manager' => 'Responsable', default => 'Membre équipe' } }}</span></td><td class="px-6 py-4"><span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700"><span class="h-2 w-2 rounded-full bg-emerald-500"></span>{{ ucfirst($user->pivot->status) }}</span></td><td class="px-6 py-4 text-right">@if (! $user->is(auth()->user()))<form method="POST" action="{{ route('settings.users.destroy', $user) }}" onsubmit="return confirm('Retirer cet utilisateur de l’église ?');">@csrf @method('DELETE')<button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-bold text-rose-700 hover:bg-rose-50">Retirer</button></form>@else<span class="text-xs text-slate-400">Votre compte</span>@endif</td></tr>@endforeach</tbody></table></div></div>
    </div>
</x-app-layout>
