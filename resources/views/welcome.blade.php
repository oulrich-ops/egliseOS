<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ÉgliseOS') }} | Gestion d'église</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f5f7f2] text-slate-900 antialiased">
        <header class="relative overflow-hidden border-b border-emerald-950/10 bg-[#123c35] text-white">
            <div class="absolute -right-24 -top-36 h-96 w-96 rounded-full border-[48px] border-amber-300/15"></div>
            <div class="absolute -bottom-48 left-1/3 h-80 w-80 rounded-full bg-emerald-500/10 blur-3xl"></div>

            <nav class="relative mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-300 text-[#123c35]"><i data-lucide="cross" class="h-6 w-6 stroke-[3]"></i></span>
                    <span class="text-lg font-bold tracking-tight">ÉgliseOS</span>
                </a>
                <div class="flex items-center gap-3 text-sm font-semibold">
                    <div class="flex items-center gap-1 rounded-lg border border-white/15 p-1 text-xs">
                        <a href="{{ route('locale.update', 'fr') }}" class="rounded-md px-2 py-1 {{ app()->getLocale() === 'fr' ? 'bg-amber-300 text-[#123c35]' : 'text-emerald-50/70' }}">FR</a>
                        <a href="{{ route('locale.update', 'en') }}" class="rounded-md px-2 py-1 {{ app()->getLocale() === 'en' ? 'bg-amber-300 text-[#123c35]' : 'text-emerald-50/70' }}">EN</a>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-white/10 px-4 py-2 hover:bg-white/20">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-emerald-50 hover:bg-white/10">Se connecter</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-[#123c35] shadow-sm hover:bg-amber-200">Créer un espace</a>
                        @endif
                    @endauth
                </div>
            </nav>

            <div class="relative mx-auto grid max-w-7xl gap-14 px-6 pb-24 pt-14 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:px-8 lg:pb-32 lg:pt-24">
                <div>
                    <p class="mb-5 text-sm font-bold uppercase tracking-[0.25em] text-amber-300">Une église mieux organisée</p>
                    <h1 class="max-w-3xl text-5xl font-black leading-[1.02] tracking-tight sm:text-6xl">Gérez votre communauté avec confiance.</h1>
                    <p class="mt-7 max-w-xl text-lg leading-8 text-emerald-50/80">ÉgliseOS rassemble vos membres, groupes, responsabilités et statistiques dans un espace simple, sécurisé et pensé pour les équipes d'église.</p>
                    <div class="mt-9 flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-xl bg-amber-300 px-5 py-3 font-bold text-[#123c35] shadow-lg shadow-black/10 hover:bg-amber-200">Ouvrir le tableau de bord</a>
                        @else
                            <a href="{{ route('register') }}" class="rounded-xl bg-amber-300 px-5 py-3 font-bold text-[#123c35] shadow-lg shadow-black/10 hover:bg-amber-200">Commencer maintenant</a>
                            <a href="{{ route('login') }}" class="rounded-xl border border-white/20 px-5 py-3 font-bold text-white hover:bg-white/10">J'ai déjà un compte</a>
                        @endauth
                    </div>
                </div>

                <div class="relative rounded-3xl border border-white/15 bg-white/10 p-3 shadow-2xl shadow-emerald-950/25 backdrop-blur-sm">
                    <div class="rounded-2xl bg-[#f8faf6] p-5 text-slate-900 sm:p-7">
                        <div class="border-b border-slate-200 pb-5">
                            <p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Une communauté qui avance</p>
                            <h2 class="mt-2 text-2xl font-black tracking-tight">Les bonnes personnes, au bon endroit.</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Organisez les informations qui permettent à vos équipes de mieux accompagner chaque membre.</p>
                        </div>
                        <div class="py-5">
                            <div class="mb-3 flex items-center justify-between">
                                <p class="text-sm font-bold">Cette semaine</p>
                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">3 actions</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-sm">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-black text-amber-800">AM</span>
                                    <div class="min-w-0 flex-1"><p class="truncate text-sm font-bold">Accueillir les nouveaux membres</p><p class="mt-0.5 text-xs text-slate-500">Équipe accueil · aujourd'hui</p></div>
                                    <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-amber-400"></span>
                                </div>
                                <div class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-sm">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sm font-black text-sky-800">JG</span>
                                    <div class="min-w-0 flex-1"><p class="truncate text-sm font-bold">Mettre à jour un groupe</p><p class="mt-0.5 text-xs text-slate-500">Jeunesse · demain</p></div>
                                    <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-sky-400"></span>
                                </div>
                                <div class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-sm">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-black text-emerald-800">MP</span>
                                    <div class="min-w-0 flex-1"><p class="truncate text-sm font-bold">Préparer la réunion d'équipe</p><p class="mt-0.5 text-xs text-slate-500">Administration · vendredi</p></div>
                                    <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-emerald-500"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between rounded-xl bg-[#123c35] p-4 text-white">
                            <div><p class="text-sm font-bold">Votre prochaine étape</p><p class="mt-1 text-xs text-emerald-50/70">Créer votre premier groupe</p></div>
                            <i data-lucide="arrow-right" class="h-5 w-5 text-amber-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
                <div class="max-w-2xl">
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Tout au même endroit</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Les outils essentiels pour prendre soin de votre communauté.</h2>
                </div>
                <div class="mt-12 grid gap-5 md:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 font-black text-emerald-700">01</span><h3 class="mt-6 text-lg font-bold">Membres</h3><p class="mt-2 leading-7 text-slate-600">Un fichier membre fiable, filtrable et toujours à jour pour vos équipes.</p></article>
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 font-black text-amber-700">02</span><h3 class="mt-6 text-lg font-bold">Groupes & rôles</h3><p class="mt-2 leading-7 text-slate-600">Structurez les départements, associations et responsabilités de l'église.</p></article>
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 font-black text-sky-700">03</span><h3 class="mt-6 text-lg font-bold">Pilotage</h3><p class="mt-2 leading-7 text-slate-600">Suivez les indicateurs importants grâce à une vue claire de votre activité.</p></article>
                </div>
            </section>

            <section class="border-y border-emerald-950/10 bg-[#e7efe6]">
                <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-14 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                    <div><h2 class="text-2xl font-black text-[#123c35]">Prêt à mieux servir votre communauté ?</h2><p class="mt-2 text-emerald-950/65">Créez votre espace d'église et commencez à structurer vos données.</p></div>
                    @guest
                        <a href="{{ route('register') }}" class="shrink-0 rounded-xl bg-[#123c35] px-5 py-3 text-center font-bold text-white hover:bg-emerald-900">Créer mon espace</a>
                    @endguest
                </div>
            </section>
        </main>

        <footer class="mx-auto flex max-w-7xl flex-col gap-3 px-6 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <p>&copy; {{ date('Y') }} ÉgliseOS</p>
            <p>Gestion simple. Communauté engagée.</p>
        </footer>
    </body>
</html>
