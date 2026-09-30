<!DOCTYPE html>
<html lang="fr">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Lettre de recommandation - {{ $member->full_name }}</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-slate-100 p-6 text-slate-900 sm:p-12">
    <main class="mx-auto max-w-3xl">
        <div class="mb-6 flex items-center justify-between print:hidden"><a href="{{ route('members.show', $member) }}" class="text-sm font-bold text-emerald-700">Retour au dossier</a><button onclick="window.print()" class="rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white">Imprimer / PDF</button></div>
        <article class="bg-white p-8 shadow-sm sm:p-14 print:shadow-none">
            <header class="flex items-start justify-between border-b-2 border-[#123c35] pb-7"><div><p class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-600">{{ $tenant->name }}</p><h1 class="mt-2 text-2xl font-black text-[#123c35]">Lettre de recommandation</h1></div><span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#123c35] text-amber-300"><i data-lucide="cross" class="h-6 w-6 stroke-[3]"></i></span></header>
            <div class="mt-10 text-sm text-slate-600"><p>Référence : <strong>{{ $document->reference }}</strong></p><p class="mt-1">Fait le {{ $document->issued_at->format('d/m/Y') }}</p></div>
            <div class="mt-12 text-base leading-8 text-slate-700"><p>À qui de droit,</p><p class="mt-6">Par la présente, nous recommandons <strong>{{ $member->full_name }}</strong>, membre de {{ $tenant->name }}, identifié(e) sous le numéro <strong>{{ $member->member_number }}</strong>.</p><p class="mt-6">{{ $member->full_name }} participe à la vie de notre communauté et a fait preuve d’un engagement apprécié dans les activités et services qui lui sont confiés.</p>@if ($document->metadata['purpose'] ?? false)<p class="mt-6">Cette recommandation est établie dans le cadre suivant : <strong>{{ $document->metadata['purpose'] }}</strong>.</p>@endif<p class="mt-6">Nous restons disponibles pour toute information complémentaire.</p><p class="mt-8">Veuillez recevoir nos salutations respectueuses.</p></div>
            <footer class="mt-20 border-t border-slate-200 pt-5 text-sm text-slate-500"><p>Administration de {{ $tenant->name }}</p><p class="mt-1">Document généré par ÉgliseOS</p></footer>
        </article>
    </main>
</body>
</html>
