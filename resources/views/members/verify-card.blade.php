<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vérification de carte - {{ $card->member->full_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 px-4 py-10 text-slate-900 sm:px-6">
    <main class="mx-auto max-w-md">
        <div class="mb-8 text-center"><span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#123c35] text-amber-300"><i data-lucide="cross" class="h-7 w-7 stroke-[3]"></i></span><p class="mt-3 text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">Vérification officielle</p></div>
        <section class="card-surface overflow-hidden">
            <div class="{{ $isValid ? 'bg-[#123c35]' : 'bg-rose-800' }} px-6 py-7 text-center text-white"><i data-lucide="{{ $isValid ? 'badge-check' : 'badge-alert' }}" class="mx-auto h-10 w-10 text-amber-300"></i><h1 class="mt-3 text-2xl font-black">{{ $isValid ? 'Carte valide' : 'Carte invalide' }}</h1><p class="mt-1 text-sm text-white/70">{{ $card->tenant->name }}</p></div>
            <div class="space-y-5 p-6"><div><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Membre</p><p class="mt-1 text-xl font-black text-slate-900">{{ $card->member->full_name }}</p></div><div class="grid grid-cols-2 gap-4 text-sm"><div><p class="text-slate-400">Numéro membre</p><p class="mt-1 font-bold">{{ $card->member->member_number }}</p></div><div><p class="text-slate-400">Carte</p><p class="mt-1 font-bold">{{ $card->card_number }}</p></div><div><p class="text-slate-400">Statut</p><p class="mt-1 font-bold {{ $isValid ? 'text-emerald-700' : 'text-rose-700' }}">{{ ucfirst($card->status) }}</p></div><div><p class="text-slate-400">Expiration</p><p class="mt-1 font-bold">{{ $card->expires_at?->format('d/m/Y') ?: 'Sans expiration' }}</p></div></div><p class="border-t border-slate-200 pt-4 text-center text-xs text-slate-500">{{ $isValid ? 'Cette page confirme que cette carte a été émise par '.$card->tenant->name.'.' : 'Cette carte ne peut plus être utilisée. Contactez l’administration de '.$card->tenant->name.'.' }}</p></div>
        </section>
    </main>
</body>
</html>
