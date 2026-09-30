<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ÉgliseOS') }} | Accès sécurisé</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#123c35] px-4 py-10 sm:px-6">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full border-[48px] border-amber-300/15"></div>
            <div class="absolute -bottom-40 -left-24 h-80 w-80 rounded-full bg-emerald-500/10 blur-3xl"></div>

            <div class="relative w-full max-w-md">
                <div class="mb-4 flex justify-end gap-1 text-xs font-bold">
                    <a href="{{ route('locale.update', 'fr') }}" class="rounded-md px-2 py-1 {{ app()->getLocale() === 'fr' ? 'bg-amber-300 text-[#123c35]' : 'text-emerald-50/70 hover:text-white' }}">FR</a>
                    <a href="{{ route('locale.update', 'en') }}" class="rounded-md px-2 py-1 {{ app()->getLocale() === 'en' ? 'bg-amber-300 text-[#123c35]' : 'text-emerald-50/70 hover:text-white' }}">EN</a>
                </div>
                <div class="mb-8 text-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-white">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-300 text-[#123c35]"><i data-lucide="cross" class="h-7 w-7 stroke-[3]"></i></span>
                        <span class="text-xl font-bold tracking-tight">ÉgliseOS</span>
                    </a>
                    <p class="mt-4 text-sm text-emerald-50/70">La gestion simple de votre communauté</p>
                </div>

                <div class="overflow-hidden rounded-2xl border border-white/10 bg-[#f8faf6] p-6 shadow-2xl shadow-emerald-950/30 sm:p-8">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-xs text-emerald-50/50">Espace sécurisé pour les équipes d'église</p>
            </div>
        </div>
    </body>
</html>
