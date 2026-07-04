@extends('layouts.public')

@section('content')
<x-page-hero
    :eyebrow="$page->brand_scope === 'pempek-tince' ? 'Pempek Tince' : ($page->brand_scope === 'pondok-tince' ? 'Pondok Tince' : null)"
    :title="$page->hero_title ?: $page->title"
    :subtitle="$page->hero_subtitle"
    :image="media_url($page->hero_image_path)">
    @if($page->hero_cta_label && $page->hero_cta_url)
        <a href="{{ $page->hero_cta_url }}" class="btn-gold">{{ $page->hero_cta_label }}</a>
    @endif
</x-page-hero>

<x-breadcrumbs />

@if($page->intro_content)
    <section class="container-x py-12">
        <div class="prose-content mx-auto max-w-3xl">{!! $page->intro_content !!}</div>
    </section>
@endif

@foreach($page->activeSections as $section)
    @include('partials.page-section', ['section' => $section])
@endforeach

<x-faq-list :faqs="$page->faqs" />
@endsection
