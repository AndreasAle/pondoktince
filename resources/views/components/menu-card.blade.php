@props(['item', 'source' => 'menu'])

@php
    $wa = app(\App\Services\WhatsAppService::class);
    $msg = $wa->fillTemplate(
        $item->wa_message_template ?: 'Halo, saya ingin pesan {name}. Apakah tersedia?',
        ['name' => $item->name]
    );
@endphp

<article class="card group flex flex-col overflow-hidden">
    <div class="relative aspect-[4/3] overflow-hidden bg-cream-100">
        @if($item->image_path)
            <img src="{{ media_url($item->image_path) }}" alt="{{ $item->image_alt ?: $item->name }}"
                 loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-maroon-300">
                <span class="font-display text-lg">{{ $item->name }}</span>
            </div>
        @endif

        <div class="absolute left-3 top-3 flex flex-wrap gap-1">
            @if($item->is_best_seller)<span class="rounded-full bg-maroon-700 px-2.5 py-1 text-[11px] font-semibold text-cream-50">Best Seller</span>@endif
            @if($item->is_favorite)<span class="rounded-full bg-gold-500 px-2.5 py-1 text-[11px] font-semibold text-charcoal">Favorit</span>@endif
            @if($item->is_new)<span class="rounded-full bg-green-600 px-2.5 py-1 text-[11px] font-semibold text-white">Baru</span>@endif
            @if($item->is_spicy)<span class="rounded-full bg-red-600 px-2.5 py-1 text-[11px] font-semibold text-white">Pedas</span>@endif
        </div>
    </div>

    <div class="flex flex-1 flex-col p-4">
        <h3 class="font-display text-lg font-semibold text-charcoal">{{ $item->name }}</h3>
        @if($item->short_description || $item->description)
            <p class="mt-1 line-clamp-2 text-sm text-charcoal/65">{{ $item->short_description ?: strip_tags($item->description) }}</p>
        @endif

        <div class="mt-3 flex items-center justify-between">
            <div>
                @if($item->discount_price)
                    <span class="text-sm text-charcoal/40 line-through">{{ rupiah($item->price) }}</span>
                    <span class="font-semibold text-maroon-700">{{ rupiah($item->discount_price) }}</span>
                @elseif($item->price)
                    <span class="font-semibold text-maroon-700">{{ rupiah($item->price) }}</span>
                @else
                    <span class="text-sm text-charcoal/55">Menyesuaikan</span>
                @endif
                @if($item->price_note)<span class="text-xs text-charcoal/45"> / {{ $item->price_note }}</span>@endif
            </div>
        </div>

        <div class="mt-4">
            <x-wa-button :message="$msg" :brand="$item->brand?->key"
                :label="$item->cta_label ?: 'Pesan'" :source="$source"
                class="w-full !py-2.5 text-xs" />
        </div>
    </div>
</article>
