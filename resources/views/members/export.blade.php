<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des membres{{ $group ? ' - '.$group->name : '' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-start print:hidden">
            <div>
                <a href="{{ $group ? route('structures.show', $group) : route('members.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-emerald-700 hover:text-emerald-900"><i data-lucide="arrow-left" class="h-4 w-4"></i> Retour</a>
                <p class="mt-4 text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Export membres</p>
                <h1 class="mt-1 text-3xl font-black text-slate-900">{{ $group ? $group->name : 'Tous les membres' }}</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $members->count() }} membre(s) dans cette liste.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('members.export.csv', $group ? ['group' => $group->id] : []) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:border-emerald-300"><i data-lucide="download" class="h-4 w-4 text-emerald-700"></i>CSV / Excel</a>
                <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white hover:bg-emerald-900"><i data-lucide="printer" class="h-4 w-4"></i>Imprimer / PDF</button>
            </div>
        </div>

        <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 print:hidden">
            <form method="GET" action="{{ route('members.export') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1"><label for="group" class="mb-1.5 block text-sm font-bold text-slate-700">Choisir la liste</label><select id="group" name="group" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm" onchange="this.form.submit()"><option value="">Tous les membres de l’église</option>@foreach ($groups as $structure)<option value="{{ $structure->id }}" @selected($group?->id === $structure->id)>{{ $structure->name }}</option>@endforeach</select></div>
                <span class="text-xs text-slate-500">La liste est limitée à votre église.</span>
            </form>
        </div>

        <section class="overflow-hidden bg-white shadow-sm print:shadow-none">
            <header class="flex items-start justify-between border-b-2 border-[#123c35] p-6 sm:p-8"><div><p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-600">{{ $tenant->name }}</p><h2 class="mt-2 text-2xl font-black text-[#123c35]">Liste des membres{{ $group ? ' · '.$group->name : '' }}</h2><p class="mt-1 text-sm text-slate-500">Générée le {{ now()->format('d/m/Y à H:i') }}</p></div><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#123c35] text-amber-300"><i data-lucide="cross" class="h-6 w-6 stroke-[3]"></i></span></header>
            <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-200 text-left text-sm"><thead class="bg-slate-50"><tr><th class="px-6 py-3 font-bold">#</th><th class="px-6 py-3 font-bold">Nom complet</th><th class="px-6 py-3 font-bold">N° membre</th><th class="px-6 py-3 font-bold">Téléphone</th><th class="px-6 py-3 font-bold">Email</th><th class="px-6 py-3 font-bold">Ville</th><th class="px-6 py-3 font-bold">Statut</th></tr></thead><tbody class="divide-y divide-slate-200">@forelse ($members as $index => $member)<tr><td class="px-6 py-3 text-slate-400">{{ $index + 1 }}</td><td class="px-6 py-3 font-semibold">{{ $member->full_name ?: $member->first_name.' '.$member->last_name }}</td><td class="px-6 py-3 text-slate-600">{{ $member->member_number }}</td><td class="px-6 py-3 text-slate-600">{{ $member->phone ?: '—' }}</td><td class="px-6 py-3 text-slate-600">{{ $member->email ?: '—' }}</td><td class="px-6 py-3 text-slate-600">{{ $member->city ?: '—' }}</td><td class="px-6 py-3"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-bold text-emerald-700">{{ ucfirst($member->status) }}</span></td></tr>@empty<tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">Aucun membre dans cette liste.</td></tr>@endforelse</tbody></table></div>
            <footer class="border-t border-slate-200 px-6 py-4 text-xs text-slate-500 sm:px-8">Document administratif · {{ $members->count() }} membre(s)</footer>
        </section>
    </main>
</body>
</html>
