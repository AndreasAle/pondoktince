@props([
    'eyebrow' => null,
    'title' => '',
    'subtitle' => null,
    'image' => null,
])

<section class="relative overflow-hidden {{ $image ? 'bg-maroon-900' : 'lux-dark' }} text-cream-50">
    @if($image)
        <img src="{{ $image }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-br from-maroon-900 via-maroon-900/85 to-maroon-800/60"></div>
    @endif

    {{-- soft gold glow accents (seragam dengan homepage) --}}
    <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-gold-500/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-28 left-1/4 h-72 w-72 rounded-full bg-gold-400/10 blur-3xl"></div>

    <div class="container-x relative py-16 text-center lg:py-24">
        <div class="mx-auto max-w-3xl">
            @if($eyebrow)
                <div class="ornament mb-4 text-xs font-semibold uppercase tracking-[0.25em] text-gold-300">{{ $eyebrow }}</div>
            @endif
            <h1 class="h-display text-3xl leading-[1.12] text-cream-50 sm:text-4xl lg:text-5xl">{{ $title }}</h1>
            @if($subtitle)<p class="mx-auto mt-5 max-w-2xl text-cream-100/85">{{ $subtitle }}</p>@endif
            @if($slot->isNotEmpty())<div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row sm:flex-wrap">{{ $slot }}</div>@endif
        </div>
    </div>
</section>
