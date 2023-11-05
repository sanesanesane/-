<button {{ $attributes->class([
    'px-2 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transition ease-in-out duration-150'
])->merge(['class' => 'bg-blue-300']) }}>
    {{ $slot }}
</button>
