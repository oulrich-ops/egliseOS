<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-emerald-600">Membres</p>
            <h2 class="mt-1 text-2xl font-bold text-slate-900">Modifier un membre</h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="card-surface p-6">
            <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Prénom</label>
                        <input name="first_name" value="{{ old('first_name', $member->first_name) }}" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Nom</label>
                        <input name="last_name" value="{{ old('last_name', $member->last_name) }}" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Téléphone</label>
                        <input name="phone" value="{{ old('phone', $member->phone) }}" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Genre</label>
                        <select name="gender" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Sélectionner</option>
                            <option value="M" {{ old('gender', $member->gender) == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('gender', $member->gender) == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Ville</label>
                        <input name="city" value="{{ old('city', $member->city) }}" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Profession</label>
                        <input name="profession" value="{{ old('profession', $member->profession) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Téléphone secondaire</label>
                        <input name="secondary_phone" value="{{ old('secondary_phone', $member->secondary_phone) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Date de naissance</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $member->birth_date?->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Lieu de naissance</label>
                        <input name="birth_place" value="{{ old('birth_place', $member->birth_place) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Situation matrimoniale</label>
                        <select name="marital_status" class="w-full rounded-lg border border-slate-300 bg-white focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Sélectionner</option><option value="single" @selected(old('marital_status', $member->marital_status) === 'single')>Célibataire</option><option value="married" @selected(old('marital_status', $member->marital_status) === 'married')>Marié(e)</option><option value="widowed" @selected(old('marital_status', $member->marital_status) === 'widowed')>Veuf / Veuve</option><option value="divorced" @selected(old('marital_status', $member->marital_status) === 'divorced')>Divorcé(e)</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Date d’arrivée dans l’église</label>
                        <input type="date" name="arrival_date" value="{{ old('arrival_date', $member->arrival_date?->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Ancienne église</label>
                        <input name="previous_church" value="{{ old('previous_church', $member->previous_church) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="flex items-center gap-3 pt-6">
                        <input id="baptized" type="checkbox" name="baptized" value="1" @checked(old('baptized', $member->baptized)) class="h-4 w-4 rounded border-slate-400 text-emerald-700 focus:ring-emerald-600">
                        <label for="baptized" class="text-sm font-medium text-slate-700">Membre baptisé</label>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Date du baptême</label>
                        <input type="date" name="baptism_date" value="{{ old('baptism_date', $member->baptism_date?->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Adresse</label>
                        <input name="address" value="{{ old('address', $member->address) }}" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Notes internes</label>
                        <textarea name="notes" rows="3" class="w-full rounded-lg border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">{{ old('notes', $member->notes) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="photo" class="mb-1 block text-sm font-medium text-slate-700">Photo <span class="font-normal text-slate-400">(optionnelle)</span></label>
                        @if ($member->photo_path)
                            <img src="{{ asset('storage/'.$member->photo_path) }}" alt="Photo actuelle de {{ $member->full_name }}" class="mb-3 h-20 w-20 rounded-xl object-cover">
                        @endif
                        <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-50 file:px-3 file:py-1.5 file:font-semibold file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="mt-1 text-xs text-slate-500">Laissez vide pour conserver la photo actuelle.</p>
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Statut</label>
                        <select name="status" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                            <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                            <option value="pending" {{ old('status', $member->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('members.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Annuler</a>
                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
