@props(['package', 'source' => 'pempek-tince'])

@php
    $disc = $package->discountPercent();
    $avg = $package->ratingAvg();
    $sold = $package->sold_count;
@endphp

<a href="{{ route('product.package', $package->slug) }}" class="card group flex flex-col overflow-hidden {{ $package->is_recommended ? 'ring-1 ring-gold-300' : '' }}">
    @php $cardImg = $package->primaryImage(); @endphp
    <div class="relative aspect-square overflow-hidden bg-cream-100">
        @if($cardImg)
            <img src="{{ media_url($cardImg) }}" alt="{{ $package->image_alt ?: $package->name }}"
                 loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
        @else
            <div class="placeholder-food">
                <svg class="h-10 w-10 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 7l1.5 12a2 2 0 002 1.8h5a2 2 0 002-1.8L20 7M9 7V5a3 3 0 016 0v2"/></svg>
            </div>
        @endif

        @if($disc)
            <span class="absolute left-0 top-3 rounded-r-full bg-maroon-700 py-1 pl-2.5 pr-3 text-[11px] font-bold text-cream-50 shadow">-{{ $disc }}%</span>
        @endif

        <div class="absolute right-2 top-2 flex flex-col items-end gap-1">
            @if($package->is_recommended)<span class="rounded-full bg-gold-500 px-2 py-0.5 text-[10px] font-semibold uppercase text-charcoal shadow-sm">Rekomendasi</span>@endif
            @if($package->is_frozen)<span class="rounded-full bg-sky-600 px-2 py-0.5 text-[10px] font-semibold uppercase text-white shadow-sm">Frozen</span>@endif
        </div>
    </div>

    <div class="flex flex-1 flex-col p-3 sm:p-4">
        <h3 class="line-clamp-2 min-h-[2.5rem] text-sm font-semibold leading-snug text-charcoal transition group-hover:text-maroon-700">{{ $package->name }}</h3>

        <div class="mt-2">
            @if($package->discount_price)
                <span class="font-display text-base font-bold text-maroon-700">{{ rupiah($package->discount_price) }}</span>
                <span class="ml-1 text-xs text-charcoal/40 line-through">{{ rupiah($package->price) }}</span>
            @elseif($package->price)
                <span class="font-display text-base font-bold text-maroon-700">{{ rupiah($package->price) }}</span>
            @else
                <span class="text-sm font-semibold text-charcoal/55">Menyesuaikan</span>
            @endif
        </div>

        <div class="mt-2 flex items-center gap-2 text-[11px] text-charcoal/50">
            @if($avg)<span class="flex items-center gap-0.5"><span class="text-gold-500">★</span>{{ $avg }}</span>@endif
            @if($avg && $sold)<span>·</span>@endif
            @if($sold)<span>{{ $sold }}+ terjual</span>@endif
            @if(!$avg && !$sold)<span class="text-maroon-600/70">Lihat detail →</span>@endif
        </div>
    </div>
</a>
