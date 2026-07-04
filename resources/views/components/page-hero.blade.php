@props([
    'eyebrow' => null,
    'title' => '',
    'subtitle' => null,
    'image' => null,
])

<section class="relative overflow-hidden bg-maroon-900 text-cream-50">
    @if($image)
        <img src="{{ $image }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover opacity-30">
    @endif
    <div class="absolute inset-0 bg-gradient-to-r from-maroon-900 via-maroon-900/90 to-maroon-800/70"></div>
    <div class="container-x relative py-16 lg:py-20">
        @if($eyebrow)<span class="eyebrow text-gold-300">{{ $eyebrow }}</span>@endif
        <h1 class="mt-2 h-display text-3xl text-cream-50 sm:text-4xl lg:text-5xl">{{ $title }}</h1>
        @if($subtitle)<p class="mt-4 max-w-2xl text-cream-100/85">{{ $subtitle }}</p>@endif
        @if($slot->isNotEmpty())<div class="mt-7 flex flex-wrap gap-3">{{ $slot }}</div>@endif
    </div>
</section>
