@props([
    'limit' => 6,
    'eyebrow' => 'Ulasan Pelanggan',
    'title' => 'Kata Mereka tentang Kami',
    'muted' => false,
])

@php
    $reviews = \App\Models\Testimonial::active()->ordered()->limit($limit)->get();
    $totalCount = \App\Models\Testimonial::active()->count();
    $avg = \App\Models\Testimonial::active()->whereNotNull('rating')->avg('rating');
    $avg = $avg ? number_format($avg, 1) : null;

    // Kenali sumber ulasan → ikon + label (memberi kesan "komentar sosial" yang autentik).
    $sourceMeta = function ($src) {
        $l = \Illuminate\Support\Str::lower($src ?? '');
        return match (true) {
            str_contains($l, 'insta') => ['instagram', 'Instagram', 'text-[#dd2a7b]'],
            str_contains($l, 'google') => ['star', 'Google', 'text-[#4285F4]'],
            str_contains($l, 'whats') || $l === 'wa' => ['chat', 'WhatsApp', 'text-[#25D366]'],
            str_contains($l, 'face') => ['chat', 'Facebook', 'text-[#1877F2]'],
            default => ['chat', $src ?: 'Pelanggan', 'text-maroon-600'],
        };
    };
@endphp

@if($reviews->count())
<section class="{{ $muted ? 'bg-cream-100' : '' }} py-16 lg:py-20">
    <div class="container-x">
        <x-section-heading :eyebrow="$eyebrow" :title="$title" center />

        {{-- insight bar (data nyata dari ulasan yang masuk) --}}
        @if($avg || $totalCount)
            <div class="mx-auto mt-6 flex w-fit items-center gap-4 rounded-full border border-cream-200 bg-white px-5 py-2.5 shadow-sm">
                @if($avg)
                    <span class="flex items-center gap-1.5">
                        <span class="flex text-gold-500">@for($i=0;$i<5;$i++)★@endfor</span>
                        <span class="font-display text-lg font-bold text-charcoal">{{ $avg }}</span>
                    </span>
                    <span class="h-4 w-px bg-cream-200"></span>
                @endif
                <span class="text-sm text-charcoal/60">dari <strong class="text-charcoal">{{ $totalCount }}+</strong> ulasan pelanggan</span>
            </div>
        @endif

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($reviews as $t)
                @php [$ic, $label, $tone] = $sourceMeta($t->source); @endphp
                <figure class="card flex flex-col p-6 lg:p-7">
                    <header class="flex items-center gap-3">
                        @if($t->image_path)
                            <img src="{{ media_url($t->image_path) }}" alt="{{ $t->name }}" class="h-11 w-11 flex-none rounded-full object-cover">
                        @else
                            <span class="flex h-11 w-11 flex-none items-center justify-center rounded-full bg-gradient-to-br from-maroon-700 to-maroon-900 font-display font-bold text-gold-300">{{ mb_substr($t->name, 0, 1) }}</span>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-charcoal">{{ $t->name }}</p>
                            <p class="flex items-center gap-1.5 text-xs text-charcoal/50">
                                <x-ico name="{{ $ic }}" class="h-3.5 w-3.5 {{ $tone }}" /> {{ $label }}
                            </p>
                        </div>
                        <x-ico name="instagram" class="h-5 w-5 flex-none text-cream-200" />
                    </header>

                    @if($t->rating)
                        <div class="mt-4 flex text-gold-500">@for($i=0;$i<$t->rating;$i++)★@endfor</div>
                    @endif

                    <blockquote class="mt-2 flex-1 text-sm leading-relaxed text-charcoal/75">{{ $t->message }}</blockquote>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif
