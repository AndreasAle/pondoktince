<footer class="bg-maroon-900 text-cream-100">
    <div class="container-x grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-4">
        {{-- Brand --}}
        <div class="lg:col-span-1">
            @if($siteSettings->logo_path)
                <img src="{{ media_url($siteSettings->logo_path) }}" alt="{{ $siteSettings->site_name }}" class="mb-4 h-12 w-auto brightness-0 invert">
            @else
                <span class="font-display text-2xl font-bold text-cream-50">{{ $siteSettings->site_name ?: 'Pondok Tince' }}</span>
            @endif
            <p class="mt-3 text-sm leading-relaxed text-cream-100/70">
                {{ $siteSettings->tagline ?: 'Tempat makan khas Palembang untuk keluarga, tamu luar kota, dan acara. Terhubung dengan Pempek Tince untuk oleh-oleh dan pesanan pempek.' }}
            </p>
            <div class="mt-4 flex gap-3">
                @if($siteSettings->instagram_pondok)
                    <a href="{{ $siteSettings->instagram_pondok }}" target="_blank" rel="noopener" aria-label="Instagram Pondok Tince" class="rounded-full bg-white/10 p-2 hover:bg-white/20">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4C8.4 2.2 8.8 2.2 12 2.2zm0 3.3A6.5 6.5 0 1018.5 12 6.5 6.5 0 0012 5.5zm0 10.7A4.2 4.2 0 1116.2 12 4.2 4.2 0 0112 16.2zm6.8-11a1.5 1.5 0 11-1.5-1.5 1.5 1.5 0 011.5 1.5z"/></svg>
                    </a>
                @endif
                @if($siteSettings->instagram_pempek)
                    <a href="{{ $siteSettings->instagram_pempek }}" target="_blank" rel="noopener" aria-label="Instagram Pempek Tince" class="rounded-full bg-white/10 p-2 hover:bg-white/20">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4C8.4 2.2 8.8 2.2 12 2.2zm0 3.3A6.5 6.5 0 1018.5 12 6.5 6.5 0 0012 5.5zm0 10.7A4.2 4.2 0 1116.2 12 4.2 4.2 0 0112 16.2zm6.8-11a1.5 1.5 0 11-1.5-1.5 1.5 1.5 0 011.5 1.5z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Explore --}}
        <div>
            <h3 class="mb-4 font-display text-lg font-semibold text-cream-50">Jelajahi</h3>
            <ul class="space-y-2.5 text-sm text-cream-100/75">
                <li><a href="{{ route('menu') }}" class="hover:text-gold-300">Menu Pondok Tince</a></li>
                <li><a href="{{ route('paket-acara') }}" class="hover:text-gold-300">Paket Acara</a></li>
                <li><a href="{{ route('booking.create') }}" class="hover:text-gold-300">Booking Tempat</a></li>
                <li><a href="{{ route('lokasi') }}" class="hover:text-gold-300">Lokasi & Jam Buka</a></li>
                <li><a href="{{ route('galeri') }}" class="hover:text-gold-300">Galeri</a></li>
                <li><a href="{{ route('articles.index') }}" class="hover:text-gold-300">Artikel</a></li>
            </ul>
        </div>

        {{-- SEO + Pempek --}}
        <div>
            <h3 class="mb-4 font-display text-lg font-semibold text-cream-50">Kuliner & Pempek</h3>
            <ul class="space-y-2.5 text-sm text-cream-100/75">
                <li><a href="{{ url('/kuliner-palembang') }}" class="hover:text-gold-300">Kuliner Palembang</a></li>
                <li><a href="{{ url('/makanan-enak-palembang') }}" class="hover:text-gold-300">Makanan Enak Palembang</a></li>
                <li><a href="{{ url('/pempek-palembang') }}" class="hover:text-gold-300">Pempek Palembang</a></li>
                <li><a href="{{ route('pempek.index') }}" class="hover:text-gold-300">Pempek Tince</a></li>
                <li><a href="{{ route('pempek.paket') }}" class="hover:text-gold-300">Paket Pempek</a></li>
                <li><a href="{{ route('pempek.frozen') }}" class="hover:text-gold-300">Pempek Frozen</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h3 class="mb-4 font-display text-lg font-semibold text-cream-50">Hubungi Kami</h3>
            <ul class="space-y-3 text-sm text-cream-100/75">
                @if($siteSettings->address)
                    <li class="flex gap-2"><span class="text-gold-400">📍</span><span>{{ $siteSettings->address }}</span></li>
                @endif
                @if($siteSettings->whatsapp_number)
                    <li class="flex gap-2"><span class="text-gold-400">💬</span>
                        <a href="{{ wa_url('Halo '.$siteSettings->site_name.', saya ingin bertanya.') }}" target="_blank" rel="noopener nofollow" class="hover:text-gold-300">{{ $siteSettings->whatsapp_number }}</a>
                    </li>
                @endif
                @if($siteSettings->email)
                    <li class="flex gap-2"><span class="text-gold-400">✉️</span><a href="mailto:{{ $siteSettings->email }}" class="hover:text-gold-300">{{ $siteSettings->email }}</a></li>
                @endif
                @if(is_array($siteSettings->opening_hours) && count($siteSettings->opening_hours))
                    <li class="pt-1">
                        <span class="block font-medium text-cream-50">Jam Buka</span>
                        @foreach($siteSettings->opening_hours as $row)
                            <span class="block text-xs text-cream-100/60">{{ $row['day'] ?? '' }}: {{ $row['hours'] ?? '' }}</span>
                        @endforeach
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-x flex flex-col items-center justify-between gap-2 py-5 text-xs text-cream-100/60 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ $siteSettings->site_name ?: 'Pondok Tince' }}. Seluruh hak cipta dilindungi.</p>
            <p>Kuliner Khas Palembang · Pondok Tince &amp; Pempek Tince</p>
        </div>
    </div>
</footer>
