@props(['faqs', 'title' => 'Pertanyaan yang Sering Diajukan', 'eyebrow' => 'FAQ'])

@if($faqs && $faqs->count())
<section class="bg-cream-50 py-16">
    <div class="container-x">
        <x-section-heading :eyebrow="$eyebrow" :title="$title" center />

        <div class="mx-auto mt-8 max-w-3xl divide-y divide-cream-200 rounded-2xl border border-cream-200 bg-white">
            @foreach($faqs as $faq)
                <div x-data="{ open: false }" class="p-5">
                    <button type="button" @click="open = !open"
                            class="flex w-full items-center justify-between gap-4 text-left">
                        <span class="font-semibold text-charcoal">{{ $faq->question }}</span>
                        <svg class="h-5 w-5 flex-none text-maroon-600 transition" :class="open && 'rotate-180'"
                             viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z" clip-rule="evenodd"/></svg>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-3 text-sm leading-relaxed text-charcoal/70">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
