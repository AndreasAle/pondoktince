<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\BookingLead;
use App\Services\WhatsAppService;

class BookingController extends Controller
{
    public function create()
    {
        $page = $this->cmsPage('booking');

        $this->applySeo($page, [
            'title' => 'Booking Tempat & Acara | Pondok Tince',
            'description' => 'Booking meja, ruang, atau acara di Pondok Tince untuk makan keluarga, arisan, meeting, dan rombongan. Isi form, lalu konfirmasi via WhatsApp.',
            'keywords' => 'booking Pondok Tince, tempat makan acara Palembang',
        ], $this->crumbs([['name' => 'Booking', 'url' => route('booking.create')]]));

        return view('pages.booking', compact('page'));
    }

    public function store(StoreBookingRequest $request, WhatsAppService $wa)
    {
        $data = $request->validated();
        unset($data['website']);
        $data['status'] = 'new';

        $lead = BookingLead::create($data);

        // Build the WhatsApp confirmation message.
        $lines = [
            'Halo '.(settings()->site_name ?: 'Pondok Tince').', saya mau booking.',
            'Nama: '.$lead->name,
            'Tanggal: '.($lead->date?->format('d-m-Y') ?: '-'),
            'Jam: '.($lead->time ?: '-'),
            'Jumlah orang: '.($lead->people_count ?: '-'),
            'Keperluan: '.($lead->purpose ?: '-'),
            'Catatan: '.($lead->notes ?: '-'),
        ];

        $url = $wa->url(implode("\n", $lines), $lead->brand_key);

        return redirect()->away($url)
            ->with('success', 'Terima kasih! Anda akan diarahkan ke WhatsApp untuk konfirmasi booking.');
    }
}
