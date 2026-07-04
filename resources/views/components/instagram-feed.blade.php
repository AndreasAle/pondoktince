@props([
    'brand' => null,
    'limit' => 8,
    'eyebrow' => 'Instagram',
    'title' => 'Ikuti Keseharian Kami',
    'muted' => false,   // true = background cream (untuk selang-seling section)
])

@php
    $posts = \App\Models\InstagramPost::active()->ordered()
        ->when($brand, fn ($q) => $q->where('brand_key', $brand))
        ->limit($limit)->get();

    $s = settings();
    $handleUrl = $brand === 'pempek-tince'
        ? ($s->instagram_pempek ?: $s->instagram_pondok)
        : ($s->instagram_pondok ?: $s->instagram_pempek);
    $handle = $handleUrl ? '@'.trim(parse_url($handleUrl, PHP_URL_PATH) ?? '', '/') : null;
@endphp

@if($posts->count())
<section class="{{ $muted ? 'bg-cream-100' : '' }} py-16 lg:py-20">
    <div class="container-x">
        <div class="flex flex-col items-center gap-6 text-center sm:flex-row sm:items-end sm:justify-between sm:text-left">
            <x-section-heading :eyebrow="$eyebrow" :title="$title"
                :subtitle="$handle ? 'Cerita, menu, dan momen terbaru langsung dari '.$handle : null" />
            @if($handleUrl)
                <a href="{{ $handleUrl }}" target="_blank" rel="noopener"
                   class="btn-primary !py-2.5 text-xs">
                    <x-ico name="instagram" class="h-4 w-4" /> Follow {{ $handle }}
                </a>
            @endif
        </div>

        <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:gap-4">
            @foreach($posts as $post)
                <a href="{{ $post->permalink ?: ($handleUrl ?: '#') }}" target="_blank" rel="noopener"
                   class="group relative aspect-square overflow-hidden rounded-2xl bg-cream-100 ring-1 ring-cream-200"
                   aria-label="Lihat di Instagram">
                    @if($post->image_path)
                        <img src="{{ media_url($post->image_path) }}" alt="{{ $post->image_alt ?: 'Instagram Pondok Tince' }}"
                             loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                    @else
                        <div class="placeholder-food"><x-ico name="instagram" class="h-9 w-9 opacity-70" /></div>
                    @endif

                    @if($post->is_reel)
                        <span class="absolute right-2 top-2 rounded-full bg-black/45 p-1 text-cream-50 backdrop-blur">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                    @endif

                    {{-- hover overlay --}}
                    <div class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-maroon-900/90 via-maroon-900/10 to-transparent p-3 opacity-0 transition duration-300 group-hover:opacity-100">
                        <span class="flex items-center gap-1.5 text-xs font-semibold text-cream-50">
                            <x-ico name="instagram" class="h-4 w-4" /> Lihat di Instagram
                        </span>
                        @if($post->caption)
                            <span class="mt-1 line-clamp-2 text-[11px] leading-snug text-cream-100/85">{{ $post->caption }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
