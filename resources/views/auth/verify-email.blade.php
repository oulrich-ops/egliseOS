<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Dernière étape</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Vérifiez votre adresse email</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Un lien de vérification vient de vous être envoyé. Cliquez dessus pour activer votre espace.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Renvoyer le lien') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm font-medium text-emerald-700 hover:text-emerald-900">
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>
