@props(['item', 'source' => 'menu'])

@php
    $disc = $item->discountPercent();
    $avg = $item->ratingAvg();
    $sold = $item->sold_count;
@endphp

<a href="{{ route('product.menu', $item->slug) }}" class="card group flex flex-col overflow-hidden">
    <div class="relative aspect-square overflow-hidden bg-cream-100">
        @if($item->image_path)
            <img src="{{ media_url($item->image_path) }}" alt="{{ $item->image_alt ?: $item->name }}"
                 loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
        @else
            <div class="placeholder-food"><x-ico name="utensils" class="h-10 w-10 opacity-70" /></div>
        @endif

        @if($disc)
            <span class="absolute left-0 top-3 rounded-r-full bg-maroon-700 py-1 pl-2.5 pr-3 text-[11px] font-bold text-cream-50 shadow">-{{ $disc }}%</span>
        @endif

        <div class="absolute right-2 top-2 flex flex-col items-end gap-1">
            @if($item->is_best_seller)<span class="rounded-full bg-gold-500 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-charcoal shadow-sm">Best</span>@endif
            @if($item->is_new)<span class="rounded-full bg-green-600 px-2 py-0.5 text-[10px] font-semibold uppercase text-white shadow-sm">Baru</span>@endif
            @if($item->is_spicy)<span class="rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-semibold uppercase text-white shadow-sm">Pedas</span>@endif
        </div>
    </div>

    <div class="flex flex-1 flex-col p-3 sm:p-4">
        <h3 class="line-clamp-2 min-h-[2.5rem] text-sm font-semibold leading-snug text-charcoal transition group-hover:text-maroon-700">{{ $item->name }}</h3>

        <div class="mt-2">
            @if($item->discount_price)
                <span class="font-display text-base font-bold text-maroon-700">{{ rupiah($item->discount_price) }}</span>
                <span class="ml-1 text-xs text-charcoal/40 line-through">{{ rupiah($item->price) }}</span>
            @elseif($item->price)
                <span class="font-display text-base font-bold text-maroon-700">{{ rupiah($item->price) }}</span>
            @else
                <span class="text-sm font-semibold text-charcoal/55">Menyesuaikan</span>
            @endif
        </div>

        <div class="mt-2 flex items-center gap-2 text-[11px] text-charcoal/50">
            @if($avg)
                <span class="flex items-center gap-0.5"><span class="text-gold-500">★</span>{{ $avg }}</span>
            @endif
            @if($avg && $sold)<span>·</span>@endif
            @if($sold)<span>{{ $sold }}+ terjual</span>@endif
            @if(!$avg && !$sold)<span class="text-maroon-600/70">Lihat detail →</span>@endif
        </div>
    </div>
</a>
