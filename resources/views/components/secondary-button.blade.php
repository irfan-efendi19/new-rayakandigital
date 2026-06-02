<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-white border border-neutral-300 rounded-xl font-semibold text-sm text-neutral-700 shadow-sm hover:bg-neutral-50 hover:border-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition-all duration-200']) }}>
    {{ $slot }}
</button>
