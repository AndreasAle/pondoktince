@props([
    'message' => null,
    'brand' => null,        // brand key: pondok-tince | pempek-tince
    'label' => 'Pesan via WhatsApp',
    'source' => null,       // source page identifier for tracking
    'variant' => 'wa',      // wa | primary | gold | outline
    'floating' => false,
])

@php
    $wa = app(\App\Services\WhatsAppService::class);
    $url = $wa->url($message, $brand);
    $number = $wa->numberFor($brand);
    $src = $source ?? (request()->path() === '/' ? 'home' : request()->path());

    $trackPayload = [
        'source_page' => $src,
        'button_label' => $label,
        'brand_key' => $brand,
        'destination_number' => $number,
        'message_preview' => \Illuminate\Support\Str::limit($message, 120),
    ];

    $classes = match ($variant) {
        'primary' => 'btn-primary',
        'gold' => 'btn-gold',
        'outline' => 'btn-outline',
        default => 'btn-wa',
    };
@endphp

@if($floating)
    <a href="{{ $url }}" target="_blank" rel="noopener nofollow"
       @click="window.trackWhatsApp(@js($trackPayload))"
       aria-label="{{ $label }}"
       class="fixed bottom-5 right-5 z-50 flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-3 font-semibold text-white shadow-lg shadow-green-900/20 transition hover:bg-[#1ebe5b] hover:shadow-xl">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35zM12.02 2C6.5 2 2.02 6.48 2.02 12c0 1.77.46 3.45 1.34 4.95L2 22l5.2-1.36c1.45.79 3.08 1.21 4.82 1.21 5.52 0 10-4.48 10-10S17.54 2 12.02 2z"/>
        </svg>
        <span class="hidden sm:inline">{{ $label }}</span>
    </a>
@else
    <a href="{{ $url }}" target="_blank" rel="noopener nofollow"
       @click="window.trackWhatsApp(@js($trackPayload))"
       {{ $attributes->merge(['class' => $classes]) }}>
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35zM12.02 2C6.5 2 2.02 6.48 2.02 12c0 1.77.46 3.45 1.34 4.95L2 22l5.2-1.36c1.45.79 3.08 1.21 4.82 1.21 5.52 0 10-4.48 10-10S17.54 2 12.02 2z"/>
        </svg>
        {{ $label }}
    </a>
@endif
