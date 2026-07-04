<header x-data="{ mobile: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 20"
        class="sticky top-0 z-40 border-b border-cream-200/70 bg-cream-50/90 backdrop-blur transition"
        :class="scrolled && 'shadow-sm'">
    <div class="container-x flex min-h-16 items-center justify-between gap-4 py-2 lg:min-h-20">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            @if($siteSettings->logo_path)
                <img src="{{ media_url($siteSettings->logo_path) }}" alt="{{ $siteSettings->site_name }}"
                     class="site-logo"
                     style="--logo-h: {{ $siteSettings->logo_height ?: 56 }}px;">
            @else
                <span class="font-display text-xl font-bold text-maroon-700 lg:text-2xl">{{ $siteSettings->site_name ?: 'Pondok Tince' }}</span>
            @endif
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden items-center gap-7 lg:flex">
            @forelse($headerNav as $item)
                <a href="{{ $item->url }}" @if($item->open_new_tab) target="_blank" @endif
                   class="text-sm font-medium text-charcoal/75 transition hover:text-maroon-700">{{ $item->label }}</a>
            @empty
                <a href="{{ route('menu') }}" class="text-sm font-medium text-charcoal/75 hover:text-maroon-700">Menu</a>
                <a href="{{ route('pempek.index') }}" class="text-sm font-medium text-charcoal/75 hover:text-maroon-700">Pempek Tince</a>
                <a href="{{ route('paket-acara') }}" class="text-sm font-medium text-charcoal/75 hover:text-maroon-700">Paket Acara</a>
                <a href="{{ route('lokasi') }}" class="text-sm font-medium text-charcoal/75 hover:text-maroon-700">Lokasi</a>
                <a href="{{ route('articles.index') }}" class="text-sm font-medium text-charcoal/75 hover:text-maroon-700">Artikel</a>
            @endforelse
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ route('booking.create') }}" class="btn-outline !px-5 !py-2.5 text-xs">Booking</a>
            <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya ingin bertanya.'" label="WhatsApp" source="header" class="!px-5 !py-2.5 text-xs" />
        </div>

        {{-- Mobile toggle --}}
        <button @click="mobile = !mobile" class="lg:hidden" aria-label="Buka menu">
            <svg x-show="!mobile" class="h-7 w-7 text-maroon-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="mobile" x-cloak class="h-7 w-7 text-maroon-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobile" x-cloak x-collapse class="border-t border-cream-200 bg-cream-50 lg:hidden">
        <nav class="container-x flex flex-col gap-1 py-4">
            @php $nav = $mobileNav->isNotEmpty() ? $mobileNav : $headerNav; @endphp
            @forelse($nav as $item)
                <a href="{{ $item->url }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">{{ $item->label }}</a>
            @empty
                <a href="{{ route('menu') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">Menu</a>
                <a href="{{ route('pempek.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">Pempek Tince</a>
                <a href="{{ route('paket-acara') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">Paket Acara</a>
                <a href="{{ route('lokasi') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">Lokasi</a>
                <a href="{{ route('galeri') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">Galeri</a>
                <a href="{{ route('articles.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">Artikel</a>
                <a href="{{ route('kontak') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal/80 hover:bg-cream-100">Kontak</a>
            @endforelse
            <div class="mt-3 flex flex-col gap-2">
                <a href="{{ route('booking.create') }}" class="btn-primary w-full">Booking Tempat</a>
                <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya ingin bertanya.'" label="Chat WhatsApp" source="mobile-menu" class="w-full" />
            </div>
        </nav>
    </div>
</header>
