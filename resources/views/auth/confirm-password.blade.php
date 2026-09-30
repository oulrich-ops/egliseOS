<x-guest-layout>
    <div class="mb-7">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Vérification</p>
        <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Confirmez votre identité</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Cette zone est protégée. Confirmez votre mot de passe pour continuer.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirmer') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
