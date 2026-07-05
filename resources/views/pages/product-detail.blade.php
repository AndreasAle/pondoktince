@extends('layouts.public')

@section('content')
@php
    $wa = app(\App\Services\WhatsAppService::class);
    $waNumber = $wa->numberFor($brandKey);
    $unit = $product->effectivePrice();
    $unitNum = $unit ? (float) $unit : null;
    $discount = $product->discountPercent();
    $gallery = collect([$product->image_path])->merge($product->gallery ?? [])->filter()->unique()->values();
    $brandName = $brandKey === 'pempek-tince' ? 'Pempek Tince' : 'Pondok Tince';
@endphp

<div class="bg-cream-50">
<x-breadcrumbs />

<div class="container-x py-8 lg:py-12">
    <div class="grid gap-8 lg:grid-cols-12 lg:gap-10">

        {{-- ============ GALLERY ============ --}}
        <div class="lg:col-span-5" x-data="{ active: '{{ media_url($gallery->first()) }}' }">
            <div class="overflow-hidden rounded-3xl border border-cream-200 bg-white">
                <div class="aspect-square w-full bg-cream-100">
                    @if($gallery->count())
                        <img :src="active" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @else
                        <div class="placeholder-food h-full"><x-ico name="{{ $type === 'paket' ? 'fish' : 'utensils' }}" class="h-14 w-14 opacity-70" /></div>
                    @endif
                </div>
            </div>
            @if($gallery->count() > 1)
                <div class="mt-3 flex gap-3">
                    @foreach($gallery as $g)
                        <button @click="active = '{{ media_url($g) }}'"
                                :class="active === '{{ media_url($g) }}' ? 'ring-2 ring-maroon-600' : 'ring-1 ring-cream-200'"
                                class="h-16 w-16 flex-none overflow-hidden rounded-xl bg-cream-100">
                            <img src="{{ media_url($g) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ============ INFO + BUY ============ --}}
        <div class="lg:col-span-7">
            <div class="grid gap-8 lg:grid-cols-12">
                {{-- main info --}}
                <div class="lg:col-span-7">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($product->is_best_seller ?? false)<span class="rounded-full bg-maroon-700 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-cream-50">Best Seller</span>@endif
                        @if($product->is_frozen ?? false)<span class="rounded-full bg-sky-600 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-white">Frozen</span>@endif
                        @if($product->is_recommended ?? false)<span class="rounded-full bg-gold-500 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-charcoal">Rekomendasi</span>@endif
                    </div>

                    <h1 class="mt-3 font-display text-2xl font-bold text-charcoal sm:text-3xl">{{ $product->name }}</h1>

                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-charcoal/60">
                        @if($ratingCount)
                            <span class="flex items-center gap-1"><span class="text-gold-500">★</span><strong class="text-charcoal">{{ $ratingAvg }}</strong> ({{ $ratingCount }} ulasan)</span>
                        @else
                            <span class="flex items-center gap-1 text-charcoal/40"><span>★</span> Belum ada ulasan</span>
                        @endif
                        @if($product->sold_count)<span>·</span><span><strong class="text-charcoal">{{ $product->sold_count }}+</strong> terjual</span>@endif
                    </div>

                    {{-- price --}}
                    <div class="mt-5 rounded-2xl bg-cream-100 p-5">
                        @if($unit)
                            <div class="flex flex-wrap items-baseline gap-3">
                                <span class="font-display text-3xl font-bold text-maroon-700">{{ rupiah($unit) }}</span>
                                @if($discount)
                                    <span class="text-base text-charcoal/40 line-through">{{ rupiah($product->price) }}</span>
                                    <span class="rounded-md bg-maroon-700/10 px-2 py-0.5 text-sm font-bold text-maroon-700">-{{ $discount }}%</span>
                                @endif
                            </div>
                            @if($product->price_note)<p class="mt-1 text-xs text-charcoal/50">{{ $product->price_note }}</p>@endif
                        @else
                            <span class="font-display text-2xl font-bold text-maroon-700">Harga Menyesuaikan</span>
                            <p class="mt-1 text-sm text-charcoal/55">Hubungi kami untuk info harga terbaru.</p>
                        @endif
                    </div>

                    @if($product->short_description)
                        <p class="mt-5 text-charcoal/75">{{ $product->short_description }}</p>
                    @endif

                    {{-- specs --}}
                    <dl class="mt-6 grid grid-cols-2 gap-y-3 text-sm">
                        <dt class="text-charcoal/50">Kondisi</dt><dd class="font-medium text-charcoal">Baru</dd>
                        @if($product->weight)<dt class="text-charcoal/50">Berat</dt><dd class="font-medium text-charcoal">{{ $product->weight }}</dd>@endif
                        <dt class="text-charcoal/50">Etalase</dt><dd class="font-medium text-charcoal">{{ $type === 'paket' ? 'Paket Pempek' : 'Menu' }}</dd>
                        @if(!is_null($product->stock))<dt class="text-charcoal/50">Stok</dt><dd class="font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock > 0 ? 'Tersedia ('.$product->stock.')' : 'Habis' }}</dd>@endif
                    </dl>
                </div>

                {{-- buy box (WhatsApp checkout, no on-site payment) --}}
                <div class="lg:col-span-5">
                    <div x-data="buyBox({ unit: {{ $unitNum ?? 'null' }}, name: @js($product->name), number: @js($waNumber), brand: @js($brandName) })"
                         class="lg:sticky lg:top-24 rounded-2xl border border-cream-200 bg-white p-5 shadow-sm">
                        <p class="font-display text-base font-semibold text-charcoal">Atur jumlah & pesan</p>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-sm text-charcoal/60">Jumlah</span>
                            <div class="flex items-center rounded-full border border-cream-200">
                                <button @click="dec()" class="flex h-9 w-9 items-center justify-center text-maroon-700 disabled:text-charcoal/25" :disabled="qty<=1">−</button>
                                <input x-model.number="qty" type="number" min="1" class="w-12 border-0 bg-transparent p-0 text-center text-sm font-semibold focus:ring-0">
                                <button @click="inc()" class="flex h-9 w-9 items-center justify-center text-maroon-700">+</button>
                            </div>
                        </div>

                        <div class="mt-3">
                            <textarea x-model="notes" rows="2" placeholder="Catatan (opsional): rasa, cuko terpisah, dll."
                                      class="w-full rounded-xl border border-cream-200 px-3 py-2 text-sm focus:border-maroon-500 focus:ring-maroon-500"></textarea>
                        </div>

                        <template x-if="unit">
                            <div class="mt-4 flex items-center justify-between border-t border-cream-200 pt-3">
                                <span class="text-sm text-charcoal/60">Subtotal</span>
                                <span class="font-display text-xl font-bold text-maroon-700" x-text="rupiah(subtotal)"></span>
                            </div>
                        </template>

                        <a :href="waUrl()" target="_blank" rel="noopener nofollow"
                           @click="window.trackWhatsApp({ source_page: 'produk-{{ $type }}', button_label: 'Beli via WhatsApp', brand_key: '{{ $brandKey }}', destination_number: '{{ $waNumber }}', message_preview: name })"
                           class="btn-wa mt-4 w-full">
                            <x-ico name="chat" class="h-4 w-4" /> Beli via WhatsApp
                        </a>
                        <p class="mt-2 text-center text-[11px] leading-snug text-charcoal/45">Pembayaran & pengiriman dikonfirmasi langsung via WhatsApp. Tanpa transaksi di website.</p>
                    </div>
                </div>
            </div>

            {{-- seller / shipping strip --}}
            <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 rounded-2xl border border-cream-200 bg-white p-4 text-sm">
                <span class="flex items-center gap-2"><x-icon-badge name="{{ $type === 'paket' ? 'fish' : 'utensils' }}" size="sm" /><span><span class="block font-semibold text-charcoal">{{ $brandName }}</span><span class="text-xs text-charcoal/50">Penjual resmi</span></span></span>
                <span class="hidden h-8 w-px bg-cream-200 sm:block"></span>
                <span class="flex items-center gap-2 text-charcoal/70"><x-ico name="pin" class="h-5 w-5 text-gold-600" /> Dikirim dari Palembang</span>
                <span class="flex items-center gap-2 text-charcoal/70"><x-ico name="truck" class="h-5 w-5 text-gold-600" /> Konfirmasi ongkir via WhatsApp</span>
            </div>
        </div>
    </div>
</div>

{{-- ============ DETAIL PRODUK ============ --}}
<div class="container-x pb-12">
    <div class="grid gap-8 lg:grid-cols-3 lg:gap-12">
        <div class="lg:col-span-2">
            <h2 class="flex items-center gap-2 font-display text-xl font-bold text-charcoal"><span class="keyline"></span> Detail Produk</h2>
            <div class="prose-content mt-4 max-w-none">
                @if($product->description)
                    {!! nl2br(e($product->description)) !!}
                @else
                    <p>{{ $product->short_description ?: 'Produk khas Palembang dari '.$brandName.'. Hubungi kami untuk informasi lebih lanjut.' }}</p>
                @endif
            </div>

            @if($type === 'paket' && is_array($product->contents) && count($product->contents))
                <h3 class="mt-6 font-display text-lg font-semibold text-charcoal">Isi Paket</h3>
                <ul class="mt-3 space-y-2">
                    @foreach($product->contents as $c)
                        <li class="flex items-start gap-2 text-sm text-charcoal/75">
                            <x-ico name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-gold-500" />
                            <span>{{ is_array($c) ? ($c['item'] ?? reset($c)) : $c }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- cross links --}}
        <aside class="lg:col-span-1">
            <div class="rounded-2xl lux-dark p-6 text-cream-50">
                <h3 class="font-display text-lg font-bold">Butuh bantuan?</h3>
                <p class="mt-2 text-sm text-cream-100/80">Tanya ketersediaan, varian, atau pengiriman langsung ke admin.</p>
                <div class="mt-4">
                    <x-wa-button :message="'Halo '.$brandName.', saya mau tanya soal '.$product->name.'.'" :brand="$brandKey" label="Tanya via WhatsApp" source="produk-{{ $type }}-aside" variant="gold" class="w-full" />
                </div>
            </div>
        </aside>
    </div>
</div>

{{-- ============ ULASAN PEMBELI ============ --}}
<div id="ulasan" class="border-t border-cream-200 bg-cream-100 py-14">
    <div class="container-x">
        <h2 class="flex items-center gap-2 font-display text-2xl font-bold text-charcoal"><span class="keyline"></span> Ulasan Pembeli</h2>

        <div class="mt-6 grid gap-8 lg:grid-cols-3">
            {{-- summary --}}
            <div class="rounded-3xl border border-cream-200 bg-white p-6">
                @if($ratingCount)
                    <div class="flex items-end gap-3">
                        <span class="font-display text-5xl font-bold text-charcoal">{{ $ratingAvg }}</span>
                        <span class="pb-1 text-sm text-charcoal/50">/ 5.0</span>
                    </div>
                    <div class="mt-1 flex text-gold-500">@for($i=0;$i<round($ratingAvg);$i++)★@endfor</div>
                    <p class="mt-1 text-sm text-charcoal/55">{{ $ratingCount }} ulasan</p>
                    <div class="mt-4 space-y-1.5">
                        @foreach($breakdown as $star => $count)
                            <div class="flex items-center gap-2 text-xs">
                                <span class="w-8 text-charcoal/60">{{ $star }} ★</span>
                                <span class="h-2 flex-1 overflow-hidden rounded-full bg-cream-200"><span class="block h-full bg-gold-400" style="width: {{ $ratingCount ? round($count / $ratingCount * 100) : 0 }}%"></span></span>
                                <span class="w-6 text-right text-charcoal/50">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-charcoal/60">Belum ada ulasan. Jadilah yang pertama memberi ulasan!</p>
                @endif
            </div>

            {{-- reviews list --}}
            <div class="lg:col-span-2">
                @if($reviews->count())
                    <div class="space-y-4">
                        @foreach($reviews as $r)
                            <figure class="rounded-2xl border border-cream-200 bg-white p-5">
                                <header class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-maroon-700 to-maroon-900 font-display font-bold text-gold-300">{{ mb_substr($r->name, 0, 1) }}</span>
                                    <div>
                                        <p class="text-sm font-semibold text-charcoal">{{ $r->name }}</p>
                                        <div class="flex items-center gap-2 text-xs text-charcoal/45">
                                            <span class="flex text-gold-500">@for($i=0;$i<$r->rating;$i++)★@endfor</span>
                                            <span>{{ $r->created_at->translatedFormat('d M Y') }}</span>
                                        </div>
                                    </div>
                                </header>
                                @if($r->comment)<blockquote class="mt-3 text-sm leading-relaxed text-charcoal/75">{{ $r->comment }}</blockquote>@endif
                            </figure>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-cream-200 bg-white p-8 text-center text-charcoal/50">Belum ada ulasan yang tampil.</div>
                @endif

                {{-- review form --}}
                <div class="mt-6 rounded-2xl border border-cream-200 bg-white p-6" x-data="{ rating: 5 }">
                    <h3 class="font-display text-lg font-semibold text-charcoal">Tulis Ulasan</h3>
                    <form method="POST" action="{{ route('product.review') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                        <input type="hidden" name="rating" x-model="rating">

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-charcoal">Rating</label>
                            <div class="flex gap-1">
                                <template x-for="s in 5" :key="s">
                                    <button type="button" @click="rating = s" class="text-2xl transition"
                                            :class="s <= rating ? 'text-gold-500' : 'text-cream-200'">★</button>
                                </template>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <input name="name" required maxlength="80" placeholder="Nama Anda"
                                   class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                        </div>
                        <textarea name="comment" rows="3" maxlength="1500" placeholder="Bagikan pengalaman Anda dengan produk ini..."
                                  class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500"></textarea>
                        <button type="submit" class="btn-primary">Kirim Ulasan</button>
                        <p class="text-xs text-charcoal/45">Ulasan tampil setelah ditinjau admin.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ RELATED ============ --}}
@if($related->count())
<div class="container-x py-14">
    <x-section-heading eyebrow="Produk Lainnya" title="Mungkin Anda Suka" center />
    <div class="mt-10 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
        @foreach($related as $rel)
            @if($type === 'paket')
                <x-package-card :package="$rel" source="produk-related" />
            @else
                <x-menu-card :item="$rel" source="produk-related" />
            @endif
        @endforeach
    </div>
</div>
@endif
</div>

@push('scripts')
<script>
    function buyBox({ unit, name, number, brand }) {
        return {
            qty: 1,
            notes: '',
            unit,
            name,
            number,
            brand,
            inc() { this.qty++; },
            dec() { if (this.qty > 1) this.qty--; },
            get subtotal() { return this.unit ? this.unit * this.qty : null; },
            rupiah(n) { return 'Rp' + Number(n || 0).toLocaleString('id-ID'); },
            waUrl() {
                const l = ['Halo ' + this.brand + ', saya mau pesan:', '• ' + this.name, 'Jumlah: ' + this.qty];
                if (this.unit) { l.push('Harga satuan: ' + this.rupiah(this.unit)); l.push('Subtotal: ' + this.rupiah(this.subtotal)); }
                else { l.push('Harga: menyesuaikan'); }
                if (this.notes) l.push('Catatan: ' + this.notes);
                l.push('', 'Mohon info ketersediaan & pengiriman ya. Terima kasih!');
                return 'https://wa.me/' + this.number + '?text=' + encodeURIComponent(l.join('\n'));
            },
        };
    }
</script>
@endpush
@endsection
