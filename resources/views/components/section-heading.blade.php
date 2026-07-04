@props([
    'eyebrow' => null,
    'title' => null,
    'subtitle' => null,
    'center' => false,
    'light' => false,
])

<div class="{{ $center ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}">
    @if($eyebrow)
        <span class="eyebrow {{ $light ? 'text-gold-300' : '' }}">{{ $eyebrow }}</span>
    @endif
    @if($title)
        <h2 class="mt-2 h-display text-3xl sm:text-4xl {{ $light ? 'text-cream-50' : '' }}">{{ $title }}</h2>
    @endif
    @if($subtitle)
        <p class="mt-3 text-base {{ $light ? 'text-cream-100/80' : 'text-charcoal/70' }}">{{ $subtitle }}</p>
    @endif
</div>
