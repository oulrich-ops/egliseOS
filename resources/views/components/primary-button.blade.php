<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-lg border border-transparent bg-[#123c35] px-4 py-2 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
