<button {{ $attributes->class([
    'px-2 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150'
])->merge(['class' => 'bg-green-500']) }}>
    {{ $slot }}
</button>
