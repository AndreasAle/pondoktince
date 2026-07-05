@php
    $s = settings();
    $wa = app(\App\Services\WhatsAppService::class);

    $igPondok = $s->instagram_pondok;
    $igPempek = $s->instagram_pempek;
    $waPondok = $wa->url('Halo Pondok Tince, saya ingin bertanya.', 'pondok-tince');
    $waPempek = $wa->url('Halo Pempek Tince, saya ingin pesan pempek.', 'pempek-tince');

    $handle = fn ($url) => $url ? '@'.trim(parse_url($url, PHP_URL_PATH) ?? '', '/') : null;
@endphp

<div x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false" class="relative">
    <button @click="open = !open" :class="open && 'ring-2 ring-gold-400'"
            class="btn-primary !px-5 !py-2.5 text-xs" aria-haspopup="true" :aria-expanded="open">
        <x-ico name="instagram" class="h-4 w-4" />
        Sosmed
        <svg class="h-3.5 w-3.5 transition" :class="open && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z" clip-rule="evenodd"/></svg>
    </button>

    <div x-show="open" x-cloak x-transition.origin.top.right
         class="absolute right-0 z-50 mt-3 w-80 overflow-hidden rounded-2xl border border-cream-200 bg-white shadow-xl shadow-maroon-900/10">
        {{-- header --}}
        <div class="lux-dark px-5 py-4 text-cream-50">
            <p class="font-display text-sm font-bold">Terhubung dengan Kami</p>
            <p class="text-[11px] text-cream-100/70">Ikuti & chat langsung — Pondok Tince &amp; Pempek Tince</p>
        </div>

        <div class="p-2">
            {{-- PONDOK TINCE --}}
            <div class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-gold-600">Pondok Tince</div>
            @if($igPondok)
                <a href="{{ $igPondok }}" target="_blank" rel="noopener" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-cream-100">
                    <x-icon-badge name="instagram" size="sm" />
                    <span class="flex-1"><span class="block text-sm font-semibold text-charcoal">Instagram</span><span class="text-xs text-charcoal/55">{{ $handle($igPondok) }}</span></span>
                    <x-ico name="arrow-right" class="h-4 w-4 text-charcoal/30 transition group-hover:translate-x-0.5 group-hover:text-maroon-600" />
                </a>
            @endif
            <a href="{{ $waPondok }}" target="_blank" rel="noopener nofollow" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-cream-100">
                <span class="flex h-10 w-10 flex-none items-center justify-center rounded-full bg-[#25D366] text-white"><x-ico name="chat" class="h-[18px] w-[18px]" /></span>
                <span class="flex-1"><span class="block text-sm font-semibold text-charcoal">WhatsApp</span><span class="text-xs text-charcoal/55">Chat admin Pondok Tince</span></span>
                <x-ico name="arrow-right" class="h-4 w-4 text-charcoal/30 transition group-hover:translate-x-0.5 group-hover:text-maroon-600" />
            </a>

            <div class="my-2 border-t border-cream-200"></div>

            {{-- PEMPEK TINCE --}}
            <div class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-gold-600">Pempek Tince</div>
            @if($igPempek)
                <a href="{{ $igPempek }}" target="_blank" rel="noopener" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-cream-100">
                    <x-icon-badge name="instagram" size="sm" />
                    <span class="flex-1"><span class="block text-sm font-semibold text-charcoal">Instagram</span><span class="text-xs text-charcoal/55">{{ $handle($igPempek) }}</span></span>
                    <x-ico name="arrow-right" class="h-4 w-4 text-charcoal/30 transition group-hover:translate-x-0.5 group-hover:text-maroon-600" />
                </a>
            @endif
            <a href="{{ $waPempek }}" target="_blank" rel="noopener nofollow" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-cream-100">
                <span class="flex h-10 w-10 flex-none items-center justify-center rounded-full bg-[#25D366] text-white"><x-ico name="chat" class="h-[18px] w-[18px]" /></span>
                <span class="flex-1"><span class="block text-sm font-semibold text-charcoal">WhatsApp</span><span class="text-xs text-charcoal/55">Pesan pempek Pempek Tince</span></span>
                <x-ico name="arrow-right" class="h-4 w-4 text-charcoal/30 transition group-hover:translate-x-0.5 group-hover:text-maroon-600" />
            </a>
        </div>
    </div>
</div>
