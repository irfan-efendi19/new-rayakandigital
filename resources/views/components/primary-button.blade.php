<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-primary to-primary-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-soft hover:shadow-md hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
