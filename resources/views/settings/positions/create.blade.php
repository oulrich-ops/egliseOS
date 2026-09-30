<x-app-layout>
    <x-slot name="header">
        <div><p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Paramètres</p><h2 class="mt-1 text-2xl font-black text-slate-900">Ajouter une fonction</h2></div>
    </x-slot>

    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="card-surface p-6 sm:p-8">
            @if ($groups->isEmpty())<div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">Créez d’abord une structure avant d’ajouter une fonction.</div>@else
            <form action="{{ route('settings.positions.store') }}" method="POST" class="space-y-6">
                @csrf
                <div><label for="group_id" class="mb-2 block text-sm font-bold text-slate-700">Structure</label><select id="group_id" name="group_id" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required><option value="">Sélectionner une structure</option>@foreach ($groups as $group)<option value="{{ $group->id }}" @selected(old('group_id') == $group->id)>{{ $group->name }}</option>@endforeach</select>@error('group_id')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="name" class="mb-2 block text-sm font-bold text-slate-700">Nom de la fonction</label><input id="name" name="name" value="{{ old('name') }}" placeholder="Ex. Responsable chorale" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>@error('name')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="description" class="mb-2 block text-sm font-bold text-slate-700">Description <span class="font-normal text-slate-400">(optionnelle)</span></label><textarea id="description" name="description" rows="4" placeholder="Décrivez les responsabilités de cette fonction..." class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description') }}</textarea></div>
                <div><label for="sort_order" class="mb-2 block text-sm font-bold text-slate-700">Ordre d’affichage</label><input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"></div>
                <div class="flex flex-col-reverse justify-end gap-3 border-t border-slate-200 pt-6 sm:flex-row"><a href="{{ route('settings.positions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">Annuler</a><button class="rounded-lg bg-[#123c35] px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-900">Enregistrer la fonction</button></div>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>
