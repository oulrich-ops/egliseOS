<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Organisation</p>
            <h2 class="mt-1 text-2xl font-black text-slate-900">Créer une structure</h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="card-surface p-6 sm:p-8">
            <form action="{{ route('structures.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-bold text-slate-700">Nom de la structure</label>
                    <input id="name" name="name" value="{{ old('name') }}" placeholder="Ex. Département jeunesse" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                    @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="type" class="mb-2 block text-sm font-bold text-slate-700">Type</label>
                        <select id="type" name="type" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                            <option value="department">Département</option>
                            <option value="group" @selected(old('type') === 'group')>Groupe</option>
                            <option value="ministry" @selected(old('type') === 'ministry')>Ministère</option>
                            <option value="association" @selected(old('type') === 'association')>Association</option>
                            <option value="committee" @selected(old('type') === 'committee')>Commission</option>
                        </select>
                    </div>
                    <div>
                        <label for="parent_id" class="mb-2 block text-sm font-bold text-slate-700">Structure parente <span class="font-normal text-slate-400">(optionnel)</span></label>
                        <select id="parent_id" name="parent_id" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Aucune</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="description" class="mb-2 block text-sm font-bold text-slate-700">Description <span class="font-normal text-slate-400">(optionnelle)</span></label>
                    <textarea id="description" name="description" rows="4" placeholder="Décrivez le rôle de cette structure..." class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description') }}</textarea>
                </div>
                <div class="flex flex-col-reverse justify-end gap-3 border-t border-slate-200 pt-6 sm:flex-row">
                    <a href="{{ route('structures.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">Annuler</a>
                    <button type="submit" class="rounded-lg bg-[#123c35] px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-900">Créer la structure</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
