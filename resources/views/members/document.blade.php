<!DOCTYPE html>
<html lang="fr">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $document->title }}</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-slate-100 p-6 text-slate-900 sm:p-12">
    <main class="mx-auto max-w-3xl"><div class="mb-6 flex items-center justify-between print:hidden"><a href="{{ route('members.show', $document->member) }}" class="text-sm font-bold text-emerald-700">Retour au dossier</a><button onclick="window.print()" class="rounded-lg bg-[#123c35] px-4 py-2 text-sm font-bold text-white">Imprimer / PDF</button></div><article class="bg-white p-8 shadow-sm sm:p-14 print:shadow-none"><p class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-600">{{ $document->tenant->name }}</p><h1 class="mt-3 text-3xl font-black text-[#123c35]">{{ $document->title }}</h1><p class="mt-3 text-sm text-slate-500">Référence {{ $document->reference }} · {{ $document->issued_at->format('d/m/Y') }}</p><div class="mt-10 whitespace-pre-line text-base leading-8 text-slate-700">{{ $document->content ?: 'Document administratif généré pour ' . $document->member->full_name . '.' }}</div></article></main>
</body>
</html>
