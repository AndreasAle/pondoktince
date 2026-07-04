@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="Reservasi"
    :title="$page?->hero_title ?: 'Booking Tempat & Acara'"
    :subtitle="$page?->hero_subtitle ?: 'Isi form berikut untuk booking meja, ruang, atau acara. Setelah dikirim, Anda akan diarahkan ke WhatsApp untuk konfirmasi.'"
    :image="media_url($page?->hero_image_path)" />

<x-breadcrumbs />

<div class="container-x grid gap-10 py-12 lg:grid-cols-5">
    <div class="lg:col-span-3">
        <div class="card p-6 sm:p-8">
            <form method="POST" action="{{ route('booking.store') }}" class="space-y-5">
                @csrf
                {{-- Honeypot --}}
                <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                <input type="hidden" name="source_page" value="{{ url()->current() }}">

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-charcoal">Nama <span class="text-red-500">*</span></label>
                        <input name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-charcoal">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input name="whatsapp_number" value="{{ old('whatsapp_number') }}" required placeholder="08xxxxxxxxxx" class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-charcoal">Tanggal</label>
                        <input type="date" name="date" value="{{ old('date') }}" class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-charcoal">Jam</label>
                        <input type="time" name="time" value="{{ old('time') }}" class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-charcoal">Jumlah orang</label>
                        <input type="number" name="people_count" value="{{ old('people_count') }}" min="1" class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-charcoal">Keperluan</label>
                        <select name="purpose" class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">
                            <option value="">Pilih keperluan</option>
                            @foreach(['Makan keluarga','Meeting','Arisan','Tamu luar kota','Acara kecil','Rombongan','Lainnya'] as $opt)
                                <option value="{{ $opt }}" @selected(old('purpose') === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-charcoal">Brand</label>
                    <div class="flex gap-4 text-sm">
                        <label class="flex items-center gap-2"><input type="radio" name="brand_key" value="pondok-tince" checked class="text-maroon-600"> Pondok Tince</label>
                        <label class="flex items-center gap-2"><input type="radio" name="brand_key" value="pempek-tince" class="text-maroon-600"> Pempek Tince</label>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-charcoal">Catatan</label>
                    <textarea name="notes" rows="3" class="w-full rounded-xl border border-cream-200 px-4 py-2.5 text-sm focus:border-maroon-500 focus:ring-maroon-500">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn-primary w-full">Kirim & Konfirmasi via WhatsApp</button>
                <p class="text-center text-xs text-charcoal/50">Data Anda tersimpan aman. Anda akan diarahkan ke WhatsApp untuk konfirmasi akhir.</p>
            </form>
        </div>
    </div>

    <aside class="lg:col-span-2">
        <div class="rounded-2xl bg-maroon-800 p-6 text-cream-50">
            <h3 class="font-display text-xl font-bold">Kenapa Booking Dulu?</h3>
            <ul class="mt-4 space-y-3 text-sm text-cream-100/85">
                <li>✓ Tempat lebih terjamin untuk rombongan</li>
                <li>✓ Persiapan lebih matang untuk acara Anda</li>
                <li>✓ Bisa konsultasi menu & kebutuhan acara</li>
            </ul>
            <div class="mt-6">
                <x-wa-button message="Halo Pondok Tince, saya ingin konsultasi acara." label="Konsultasi via WhatsApp" source="booking-aside" variant="gold" class="w-full" />
            </div>
        </div>
        @if($page?->intro_content)
            <div class="prose-content mt-6">{!! $page->intro_content !!}</div>
        @endif
    </aside>
</div>
@endsection
