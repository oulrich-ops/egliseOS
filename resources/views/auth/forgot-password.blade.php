<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Récupération</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Réinitialiser votre mot de passe</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Indiquez votre adresse email et nous vous enverrons un lien pour choisir un nouveau mot de passe.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Envoyer le lien') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
