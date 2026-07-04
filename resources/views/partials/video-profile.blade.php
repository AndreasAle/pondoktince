@php
    $v = settings();
    $vidFile = media_url($v->profile_video_path);
    $vidUrl = $v->profile_video_url;
    $poster = media_url($v->profile_video_poster);

    $ytId = youtube_id($vidUrl);
    $vimeoId = $ytId ? null : vimeo_id($vidUrl);

    // Self-hosted file, or a direct .mp4/.webm URL
    $mp4Src = $vidFile;
    if (! $mp4Src && $vidUrl && ! $ytId && ! $vimeoId
        && \Illuminate\Support\Str::endsWith(strtolower(strtok($vidUrl, '?')), ['.mp4', '.webm', '.mov'])) {
        $mp4Src = $vidUrl;
    }

    $hasVideo = $v->profile_video_enabled && ($mp4Src || $ytId || $vimeoId);
    $ambient = $mp4Src && $v->profile_video_autoplay;
    $eyebrow = $v->profile_video_eyebrow;
    $title = $v->profile_video_title ?: 'Video Profil';
    $subtitle = $v->profile_video_subtitle;
@endphp

@if($hasVideo)
<section class="relative w-full overflow-hidden lux-dark text-cream-50" x-data="{ playing: false }">
    <div class="relative min-h-[68vh] w-full lg:min-h-[86vh]">

        @if($ambient)
            {{-- ================= AMBIENT BACKGROUND VIDEO (mp4 autoplay) ================= --}}
            <video autoplay muted loop playsinline @if($poster) poster="{{ $poster }}" @endif
                   class="absolute inset-0 h-full w-full object-cover">
                <source src="{{ $mp4Src }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-gradient-to-t from-maroon-900/85 via-maroon-900/35 to-maroon-900/60"></div>

            <div class="relative z-10 flex min-h-[68vh] flex-col items-center justify-center px-5 py-16 text-center lg:min-h-[86vh]">
                @if($eyebrow)<div class="ornament mb-4 text-xs font-semibold uppercase tracking-[0.25em] text-gold-300">{{ $eyebrow }}</div>@endif
                <h2 class="max-w-3xl h-display text-3xl text-cream-50 sm:text-4xl lg:text-5xl">{{ $title }}</h2>
                @if($subtitle)<p class="mx-auto mt-4 max-w-xl text-cream-100/85">{{ $subtitle }}</p>@endif
            </div>

        @else
            {{-- ================= CLICK-TO-PLAY (mp4 / YouTube / Vimeo) ================= --}}
            {{-- Poster / backdrop (hidden once playing) --}}
            <div x-show="!playing" class="absolute inset-0">
                @if($poster)
                    <img src="{{ $poster }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-maroon-900/90 via-maroon-900/50 to-maroon-900/70"></div>
                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-gold-500/10 blur-3xl"></div>
            </div>

            {{-- The actual player, only mounted after clicking play --}}
            <template x-if="playing">
                <div class="absolute inset-0 bg-black">
                    @if($mp4Src)
                        <video src="{{ $mp4Src }}" controls autoplay playsinline class="h-full w-full object-contain"></video>
                    @elseif($ytId)
                        <iframe class="h-full w-full" src="https://www.youtube.com/embed/{{ $ytId }}?autoplay=1&rel=0&modestbranding=1"
                                title="{{ $title }}" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>
                    @elseif($vimeoId)
                        <iframe class="h-full w-full" src="https://player.vimeo.com/video/{{ $vimeoId }}?autoplay=1"
                                title="{{ $title }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    @endif
                </div>
            </template>

            {{-- Overlay content + play button (hidden once playing) --}}
            <div x-show="!playing" class="relative z-10 flex min-h-[68vh] flex-col items-center justify-center px-5 py-16 text-center lg:min-h-[86vh]">
                @if($eyebrow)<div class="ornament mb-4 text-xs font-semibold uppercase tracking-[0.25em] text-gold-300">{{ $eyebrow }}</div>@endif
                <h2 class="max-w-3xl h-display text-3xl text-cream-50 sm:text-4xl lg:text-5xl">{{ $title }}</h2>
                @if($subtitle)<p class="mx-auto mt-4 max-w-xl text-cream-100/85">{{ $subtitle }}</p>@endif

                <button @click="playing = true" aria-label="Putar video" class="group mt-9 flex flex-col items-center gap-3">
                    <span class="relative flex h-20 w-20 items-center justify-center">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold-400/40"></span>
                        <span class="relative flex h-16 w-16 items-center justify-center rounded-full bg-gold-500 text-maroon-900 shadow-lg shadow-black/40 transition duration-300 group-hover:scale-105 group-hover:bg-gold-400">
                            <svg class="ml-1 h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                    </span>
                    <span class="text-sm font-semibold tracking-wide text-cream-50">Putar Video</span>
                </button>
            </div>
        @endif
    </div>
</section>
@endif
