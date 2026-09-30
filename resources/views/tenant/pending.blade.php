<x-guest-layout>
    <div class="text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-amber-100 text-amber-700">
            <i data-lucide="clock-3" class="h-7 w-7"></i>
        </div>
        <p class="mt-6 text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Demande reçue</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Votre église est en attente de validation</h1>
        <p class="mt-4 text-sm leading-6 text-slate-500">L’administrateur doit vérifier et valider votre demande avant l’ouverture de l’espace. Vous pourrez vous connecter avec ce compte dès que la validation sera terminée.</p>
        @if ($tenant?->status === 'rejected')
            <p class="mt-5 rounded-lg bg-rose-50 p-3 text-sm font-semibold text-rose-700">Cette demande a été refusée. Contactez l’administrateur pour plus d’informations.</p>
        @endif
        <div class="mt-7 flex items-center justify-center gap-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white hover:bg-emerald-900">Se déconnecter</button>
            </form>
            <a href="{{ route('tenant.pending') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Actualiser</a>
        </div>
    </div>
</x-guest-layout>
