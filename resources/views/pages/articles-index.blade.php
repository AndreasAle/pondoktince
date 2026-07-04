@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="Artikel" title="Info & Cerita Kuliner Palembang"
    subtitle="Tips, rekomendasi, dan info seputar kuliner Palembang, pempek, dan Pondok Tince." />

<x-breadcrumbs />

<div class="container-x py-12">
    @if($categories->count())
        <div class="mb-8 flex flex-wrap gap-2">
            <a href="{{ route('articles.index') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ !$categorySlug ? 'bg-maroon-700 text-cream-50' : 'bg-cream-100 text-charcoal/70' }}">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('articles.index', ['kategori' => $cat->slug]) }}" class="rounded-full px-4 py-2 text-sm font-medium {{ $categorySlug === $cat->slug ? 'bg-maroon-700 text-cream-50' : 'bg-cream-100 text-charcoal/70' }}">{{ $cat->name }}</a>
            @endforeach
        </div>
    @endif

    @if($articles->count())
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($articles as $article)
                <article class="card group flex flex-col overflow-hidden">
                    <a href="{{ route('articles.show', $article->slug) }}" class="aspect-[16/9] overflow-hidden bg-cream-100">
                        @if($article->featured_image_path)
                            <img src="{{ media_url($article->featured_image_path) }}" alt="{{ $article->featured_image_alt ?: $article->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center px-4 text-center font-display text-maroon-300">{{ $article->title }}</div>
                        @endif
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        @if($article->category)<span class="eyebrow">{{ $article->category->name }}</span>@endif
                        <h2 class="mt-1 font-display text-lg font-semibold text-charcoal">
                            <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-maroon-700">{{ $article->title }}</a>
                        </h2>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm text-charcoal/65">{{ $article->excerpt }}</p>
                        <div class="mt-4 flex items-center justify-between text-xs text-charcoal/45">
                            <span>{{ optional($article->published_at)->translatedFormat('d M Y') }}</span>
                            <a href="{{ route('articles.show', $article->slug) }}" class="font-semibold text-maroon-700">Baca →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-10">{{ $articles->links() }}</div>
    @else
        <p class="rounded-2xl border border-dashed border-cream-200 bg-cream-50 py-16 text-center text-charcoal/50">Belum ada artikel yang dipublikasikan. Artikel akan tampil setelah dibuat dari admin.</p>
    @endif
</div>
@endsection
