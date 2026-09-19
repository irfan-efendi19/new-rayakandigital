@props(['name'])

<svg {{ $attributes->merge(['class' => 'qr-icon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('heart')
            <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z" />
            @break
        @case('check')
            <circle cx="12" cy="12" r="9" /><path d="m8 12 2.5 2.5L16 9" />
            @break
        @case('gift')
            <path d="M4 10h16v10H4zM3 7h18v3H3zM12 7v13M12 7H8.5a2 2 0 1 1 2-2c0 1.1 1.5 2 1.5 2Zm0 0h3.5a2 2 0 1 0-2-2c0 1.1-1.5 2-1.5 2Z" />
            @break
        @case('pin')
            <path d="M19 10c0 5-7 11-7 11S5 15 5 10a7 7 0 1 1 14 0Z" /><circle cx="12" cy="10" r="2.5" />
            @break
        @case('camera')
            <path d="M8 5 9.5 3h5L16 5h4a1 1 0 0 1 1 1v13H3V6a1 1 0 0 1 1-1Z" /><circle cx="12" cy="12" r="4" />
            @break
        @case('envelope')
            <rect x="3" y="5" width="18" height="14" rx="2" /><path d="m3 6 9 7 9-7" />
            @break
        @case('calendar')
            <rect x="3" y="5" width="18" height="16" rx="2" /><path d="M16 3v4M8 3v4M3 11h18m-14 4h3m4 0h3" />
            @break
        @case('arrow-left')
            <path d="m10 5-7 7 7 7M3 12h18" />
            @break
        @case('arrow-right')
            <path d="m14 5 7 7-7 7M21 12H3" />
            @break
        @case('upload')
            <path d="M12 16V3m-5 5 5-5 5 5M4 16v5h16v-5" />
            @break
        @case('bookmark')
            <path d="M6 4h12v17l-6-4-6 4Z" />
            @break
        @default
            <rect x="3" y="3" width="7" height="7" rx="1.5" /><rect x="14" y="3" width="7" height="7" rx="1.5" /><rect x="3" y="14" width="7" height="7" rx="1.5" /><path d="M14 14h3v3h4v4h-7v-3m7-4v1" />
    @endswitch
</svg>
