@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border border-slate-300 bg-white text-slate-900 shadow-sm focus:border-emerald-600 focus:ring-emerald-600']) }}>
