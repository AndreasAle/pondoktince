@props(['package', 'source' => 'pempek-tince'])

@php
    $wa = app(\App\Services\WhatsAppService::class);
    $msg = $wa->fillTemplate(
        $package->wa_message_template ?: 'Halo Pempek Tince, saya ingin pesan {name}. Mohon info stok & pengiriman.',
        ['name' => $package->name]
    );
@endphp

<article class="card group flex flex-col overflow-hidden {{ $package->is_recommended ? 'ring-2 ring-gold-400' : '' }}">
    <div class="relative aspect-[4/3] overflow-hidden bg-cream-100">
        @if($package->image_path)
            <img src="{{ media_url($package->image_path) }}" alt="{{ $package->image_alt ?: $package->name }}"
                 loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center font-display text-maroon-300">{{ $package->name }}</div>
        @endif
        <div class="absolute left-3 top-3 flex gap-1">
            @if($package->is_recommended)<span class="rounded-full bg-gold-500 px-2.5 py-1 text-[11px] font-semibold text-charcoal">Rekomendasi</span>@endif
            @if($package->is_frozen)<span class="rounded-full bg-sky-600 px-2.5 py-1 text-[11px] font-semibold text-white">Frozen</span>@endif
        </div>
    </div>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="font-display text-xl font-semibold text-charcoal">{{ $package->name }}</h3>
        @if($package->description)
            <p class="mt-1 text-sm text-charcoal/65">{{ strip_tags($package->description) }}</p>
        @endif

        @if(is_array($package->contents) && count($package->contents))
            <ul class="mt-3 space-y-1.5 text-sm text-charcoal/70">
                @foreach($package->contents as $c)
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 flex-none text-gold-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.5 7.5a1 1 0 01-1.4 0L3.3 9.7a1 1 0 011.4-1.4l3.1 3.1 6.8-6.8a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                        <span>{{ is_array($c) ? ($c['item'] ?? reset($c)) : $c }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-4 flex items-baseline gap-1">
            @if($package->price)
                <span class="font-display text-2xl font-bold text-maroon-700">{{ rupiah($package->price) }}</span>
                @if($package->price_note)<span class="text-xs text-charcoal/50">/ {{ $package->price_note }}</span>@endif
            @else
                <span class="text-sm text-charcoal/60">Harga menyesuaikan — hubungi admin</span>
            @endif
        </div>

        <div class="mt-4 pt-1">
            <x-wa-button :message="$msg" brand="pempek-tince"
                :label="$package->cta_label ?: 'Pesan Pempek'" :source="$source" class="w-full" />
        </div>
    </div>
</article>
