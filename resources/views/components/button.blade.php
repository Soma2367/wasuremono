<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex items-center justify-center
        px-5 py-2.5
        bg-indigo-600 text-white font-semibold text-sm
        rounded-2xl shadow-md
        transition-all duration-200 ease-in-out
        hover:bg-indigo-500 hover:shadow-lg
        focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1
        active:scale-95
    '
]) }}>
    {{ $slot }}
</button>