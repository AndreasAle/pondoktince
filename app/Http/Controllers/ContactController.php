<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactLead;
use App\Models\Faq;

class ContactController extends Controller
{
    public function index()
    {
        $page = $this->cmsPage('kontak');

        $this->applySeo($page, [
            'title' => 'Kontak Pondok Tince',
            'description' => 'Hubungi Pondok Tince & Pempek Tince untuk reservasi, pesanan, dan pertanyaan. WhatsApp, lokasi, dan jam buka.',
        ], $this->crumbs([['name' => 'Kontak', 'url' => route('kontak')]]));

        $faqs = Faq::active()->ordered()->where('group', 'kontak')->get();

        return view('pages.kontak', compact('page', 'faqs'));
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        unset($data['website']);
        $data['status'] = 'new';

        ContactLead::create($data);

        return back()->with('success', 'Pesan Anda sudah kami terima. Tim kami akan segera menghubungi Anda.');
    }
}
