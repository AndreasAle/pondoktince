@props([
    'eyebrow' => null,
    'title' => null,
    'subtitle' => null,
    'center' => false,
    'light' => false,
])

<div class="{{ $center ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}">
    @if($eyebrow)
        <div class="flex items-center gap-3 {{ $center ? 'justify-center' : '' }}">
            <span class="keyline {{ $light ? '!bg-gold-300' : '' }}"></span>
            <span class="eyebrow {{ $light ? 'text-gold-300' : '' }}">{{ $eyebrow }}</span>
            @if($center)<span class="keyline {{ $light ? '!bg-gold-300' : '' }}"></span>@endif
        </div>
    @endif
    @if($title)
        <h2 class="mt-3 h-display text-3xl sm:text-4xl {{ $light ? 'text-cream-50' : '' }}">{{ $title }}</h2>
    @endif
    @if($subtitle)
        <p class="mt-4 text-base leading-relaxed {{ $light ? 'text-cream-100/80' : 'text-charcoal/70' }}">{{ $subtitle }}</p>
    @endif
</div>
