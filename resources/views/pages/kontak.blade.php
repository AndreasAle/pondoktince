@extends('layouts.public')

@section('content')
@php $s = $siteSettings; @endphp
<x-page-hero eyebrow="Kontak"
    :title="$page?->hero_title ?: 'Hubungi Pondok Tince'"
    :subtitle="$page?->hero_subtitle ?: 'Ada pertanyaan seputar menu, reservasi, atau pesanan pempek? Kami siap membantu.'"
    :image="media_url($page?->hero_image_path)" />

<x-breadcrumbs />

<div class="container-x grid gap-10 py-16 lg:grid-cols-5 lg:py-20">
    {{-- Form --}}
    <div class="lg:col-span-3">
        <div class="card p-6 sm:p-8">
            <h2 class="font-display text-2xl font-bold text-charcoal">Kirim Pesan</h2>
            <p class="mt-1 text-sm text-charcoal/60">Isi form, tim kami akan menghubungi Anda.</p>
            <form method="POST" action="{{ route('kontak.store') }}" class="mt-6 space-y-4">
                @csrf
                <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                <input type="hidden" name="source_page" value="{{ url()->current() }}">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-charcoal">Nama <span class="text-red-500">*</span></label>
                    <input name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-charcoal">WhatsApp / Email <span class="text-red-500">*</span></label>
                    <input name="contact" value="{{ old('contact') }}" required class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-charcoal">Pesan <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="4" required class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn-primary w-full">Kirim Pesan</button>
            </form>
        </div>
    </div>

    {{-- Info --}}
    <div class="lg:col-span-2 space-y-4">
        <div class="card p-6">
            <h3 class="font-display text-xl font-semibold text-charcoal">Info Kontak</h3>
            <ul class="mt-4 space-y-4 text-sm">
                @if($s->address)
                    <li class="flex gap-3"><x-icon-badge name="pin" size="sm" />
                        <span class="pt-2 text-charcoal/75">{{ $s->address }}</span></li>
                @endif
                @if($s->email)
                    <li class="flex gap-3"><x-icon-badge name="mail" size="sm" />
                        <a href="mailto:{{ $s->email }}" class="pt-2 text-charcoal/75 hover:text-maroon-700">{{ $s->email }}</a></li>
                @endif
                @if($s->instagram_pondok)
                    <li class="flex gap-3"><x-icon-badge name="instagram" size="sm" />
                        <a href="{{ $s->instagram_pondok }}" target="_blank" rel="noopener" class="pt-2 text-charcoal/75 hover:text-maroon-700">Instagram Pondok Tince</a></li>
                @endif
                @if($s->instagram_pempek)
                    <li class="flex gap-3"><x-icon-badge name="instagram" size="sm" />
                        <a href="{{ $s->instagram_pempek }}" target="_blank" rel="noopener" class="pt-2 text-charcoal/75 hover:text-maroon-700">Instagram Pempek Tince</a></li>
                @endif
            </ul>
        </div>
        <div class="flex flex-col gap-2 rounded-2xl lux-dark p-6 text-cream-50">
            <h3 class="font-display text-lg font-bold">Butuh Respons Cepat?</h3>
            <p class="text-sm text-cream-100/80">Chat langsung via WhatsApp — biasanya kami balas cepat.</p>
            <div class="mt-3 flex flex-col gap-2">
                <x-wa-button :message="'Halo '.$s->site_name.', saya ingin bertanya.'" label="Chat Pondok Tince" source="kontak" class="w-full" />
                <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Chat Pempek Tince" source="kontak" variant="gold" class="w-full" />
            </div>
        </div>
    </div>
</div>

<x-faq-list :faqs="$faqs" title="Pertanyaan Umum" />
@endsection
