@php
    /** @var \App\Models\PageSection $section */
    $bg = match ($section->background_style) {
        'muted' => 'bg-cream-100',
        'dark' => 'bg-maroon-900 text-cream-50',
        'brand' => 'bg-maroon-800 text-cream-50',
        default => 'bg-cream-50',
    };
    $settings = $section->settings ?? [];
    $brandKey = $settings['brand_key'] ?? null;
    $limit = (int) ($settings['limit'] ?? 6);
@endphp

<section class="{{ $bg }} py-14">
    <div class="container-x">
        @if($section->title || $section->subtitle)
            <x-section-heading :title="$section->title" :subtitle="$section->subtitle"
                :light="in_array($section->background_style, ['dark','brand'])"
                :center="in_array($section->type, ['cta','gallery','testimonial','faq','brand_cards','package_cards','menu_grid','product_grid'])" />
        @endif

        <div class="{{ ($section->title || $section->subtitle) ? 'mt-8' : '' }}">
            @switch($section->type)

                @case('text')
                @case('seo_content')
                    <div class="prose-content mx-auto max-w-3xl {{ in_array($section->background_style,['dark','brand']) ? '!text-cream-100/85' : '' }}">{!! $section->content !!}</div>
                    @break

                @case('image_text')
                    <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                        <div class="overflow-hidden rounded-2xl bg-cream-100">
                            @if($section->image_path)<img src="{{ media_url($section->image_path) }}" alt="{{ $section->title }}" loading="lazy" class="w-full object-cover">@endif
                        </div>
                        <div class="prose-content">{!! $section->content !!}
                            @if($section->button_label && $section->button_url)<div class="mt-5"><a href="{{ $section->button_url }}" class="btn-primary">{{ $section->button_label }}</a></div>@endif
                        </div>
                    </div>
                    @break

                @case('menu_grid')
                    @php $items = \App\Models\MenuItem::available()->with('brand')
                        ->when($brandKey, fn($q) => $q->forBrandKey($brandKey))->ordered()->limit($limit)->get(); @endphp
                    <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-3">
                        @foreach($items as $item)<x-menu-card :item="$item" source="cms-section" />@endforeach
                    </div>
                    @break

                @case('product_grid')
                @case('package_cards')
                    @php $packages = \App\Models\ProductPackage::active()
                        ->when($brandKey, fn($q) => $q->whereHas('brand', fn($b) => $b->where('key',$brandKey)))
                        ->ordered()->limit($limit)->get(); @endphp
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($packages as $pkg)<x-package-card :package="$pkg" source="cms-section" />@endforeach
                    </div>
                    @break

                @case('gallery')
                    @php $gallery = \App\Models\Gallery::active()->ordered()
                        ->when($brandKey, fn($q) => $q->whereHas('brand', fn($b) => $b->where('key',$brandKey)))->limit($limit ?: 8)->get(); @endphp
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach($gallery as $g)
                            <div class="aspect-square overflow-hidden rounded-xl bg-cream-200"><img src="{{ media_url($g->image_path) }}" alt="{{ $g->alt_text ?: 'Galeri' }}" loading="lazy" class="h-full w-full object-cover"></div>
                        @endforeach
                    </div>
                    @break

                @case('testimonial')
                    @php $tst = \App\Models\Testimonial::active()->ordered()->limit($limit)->get(); @endphp
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($tst as $t)
                            <figure class="card p-6"><div class="text-gold-500">@for($i=0;$i<($t->rating?:5);$i++)★@endfor</div>
                                <blockquote class="mt-3 text-sm text-charcoal/75">"{{ $t->message }}"</blockquote>
                                <figcaption class="mt-3 text-sm font-semibold text-charcoal">{{ $t->name }}</figcaption></figure>
                        @endforeach
                    </div>
                    @break

                @case('brand_cards')
                    @php $brands = \App\Models\Brand::active()->ordered()->get(); @endphp
                    <div class="grid gap-6 md:grid-cols-2">
                        @foreach($brands as $b)
                            <div class="card p-6"><h3 class="font-display text-xl font-bold text-charcoal">{{ $b->name }}</h3>
                                <p class="mt-2 text-sm text-charcoal/70">{{ $b->description }}</p>
                                @if($b->key === 'pempek-tince')<a href="{{ route('pempek.index') }}" class="mt-4 inline-block btn-primary !py-2.5 text-xs">Lihat Pempek Tince</a>
                                @else<a href="{{ route('menu') }}" class="mt-4 inline-block btn-primary !py-2.5 text-xs">Lihat Menu</a>@endif
                            </div>
                        @endforeach
                    </div>
                    @break

                @case('article_list')
                    @php $arts = \App\Models\Article::published()->latestFirst()->limit($limit)->get(); @endphp
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach($arts as $a)
                            <a href="{{ route('articles.show', $a->slug) }}" class="card overflow-hidden">
                                <div class="aspect-[16/9] bg-cream-100">@if($a->featured_image_path)<img src="{{ media_url($a->featured_image_path) }}" alt="{{ $a->title }}" class="h-full w-full object-cover">@endif</div>
                                <div class="p-4"><h3 class="font-display font-semibold text-charcoal">{{ $a->title }}</h3></div>
                            </a>
                        @endforeach
                    </div>
                    @break

                @case('location_map')
                    <div class="overflow-hidden rounded-2xl border border-cream-200 bg-white">
                        @if(settings()->maps_embed)<iframe src="{{ settings()->maps_embed }}" class="h-96 w-full" style="border:0" loading="lazy" title="Lokasi"></iframe>@endif
                    </div>
                    @break

                @case('cta')
                    <div class="text-center">
                        @if($section->content)<div class="prose-content mx-auto max-w-xl {{ in_array($section->background_style,['dark','brand']) ? '!text-cream-100/85' : '' }}">{!! $section->content !!}</div>@endif
                        @if($section->button_label && $section->button_url)<div class="mt-6"><a href="{{ $section->button_url }}" class="btn-gold">{{ $section->button_label }}</a></div>@endif
                    </div>
                    @break

                @case('custom_html')
                    <div>{!! $section->content !!}</div>
                    @break

                @default
                    @if($section->content)<div class="prose-content mx-auto max-w-3xl">{!! $section->content !!}</div>@endif
            @endswitch
        </div>
    </div>
</section>
