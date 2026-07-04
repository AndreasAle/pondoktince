@extends('layouts.public')

@section('content')
<article class="pb-14">
    <x-page-hero :eyebrow="$article->category?->name ?: 'Artikel'"
        :title="$article->title"
        :image="media_url($article->featured_image_path)" />

    <x-breadcrumbs />

    <div class="container-x grid gap-10 py-12 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="mb-6 flex items-center gap-3 text-sm text-charcoal/50">
                <span>{{ $article->author ?: $siteSettings->site_name }}</span>
                <span>·</span>
                <span>{{ optional($article->published_at)->translatedFormat('d F Y') }}</span>
                @if($article->reading_time)<span>·</span><span>{{ $article->reading_time }} mnt baca</span>@endif
            </div>

            @if($article->excerpt)<p class="mb-6 text-lg font-medium text-charcoal/80">{{ $article->excerpt }}</p>@endif

            <div class="prose-content max-w-none">{!! $article->content !!}</div>

            <div class="mt-8 rounded-2xl bg-cream-100 p-6 text-center">
                <p class="text-charcoal/75">Tertarik mencoba langsung?</p>
                <div class="mt-3 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('menu') }}" class="btn-primary !py-2.5 text-xs">Lihat Menu</a>
                    <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya baca artikel dan ingin bertanya.'" label="Chat via WhatsApp" source="artikel" class="!py-2.5 text-xs" />
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            @if($related->count())
                <div class="card p-5">
                    <h3 class="font-display text-lg font-semibold text-charcoal">Artikel Lainnya</h3>
                    <ul class="mt-3 space-y-3">
                        @foreach($related as $r)
                            <li>
                                <a href="{{ route('articles.show', $r->slug) }}" class="flex gap-3 group">
                                    <span class="h-14 w-14 flex-none overflow-hidden rounded-lg bg-cream-100">
                                        @if($r->featured_image_path)<img src="{{ media_url($r->featured_image_path) }}" alt="{{ $r->title }}" class="h-full w-full object-cover">@endif
                                    </span>
                                    <span class="text-sm font-medium text-charcoal/80 group-hover:text-maroon-700">{{ $r->title }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="rounded-2xl bg-maroon-800 p-6 text-cream-50">
                <h3 class="font-display text-lg font-bold">Pesan Pempek Tince</h3>
                <p class="mt-2 text-sm text-cream-100/80">Oleh-oleh khas Palembang, praktis dan bisa dikirim.</p>
                <div class="mt-4"><x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek" source="artikel-aside" variant="gold" class="w-full" /></div>
            </div>
        </aside>
    </div>
</article>
@endsection
