<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

/**
 * Isi data bisnis asli Pondok Tince (alamat, WhatsApp, Google Maps) menggantikan
 * placeholder/nomor dummy. Idempotent & aman: hanya menimpa nilai yang masih
 * placeholder / dummy / kosong, sehingga tidak menghapus data asli yang sudah
 * diisi lewat admin di production.
 */
return new class extends Migration
{
    public function up(): void
    {
        $s = SiteSetting::current();
        if (! $s) {
            return;
        }

        $address = 'Jl. Mayor Ruslan No. 794-795, RT 013/RW 004, Kel. 20 Ilir D. I, '
            .'Kec. Ilir Timur I, Kota Palembang, Sumatera Selatan 30126';
        $mapsEmbed = 'https://maps.google.com/maps?width=100%25&height=400&hl=id&q=Pondok%20Tince%20Palembang&t=&z=16&ie=UTF8&iwloc=B&output=embed';
        $mapsLink = 'https://www.google.com/maps/search/?api=1&query=Pondok+Tince+Palembang';

        // Alamat: ganti kalau masih placeholder [GANTI] atau kosong.
        if (! $s->address || str_contains($s->address, '[GANTI]') || str_contains($s->address, 'GANTI')) {
            $s->address = $address;
        }

        // WhatsApp: ganti nomor dummy 6281234567890 / kosong dengan nomor asli.
        if (! $s->whatsapp_number || $s->whatsapp_number === '6281234567890') {
            $s->whatsapp_number = '6281994900173'; // Pondok Tince (0819 9490 0173)
        }
        if (! $s->whatsapp_number_pempek || $s->whatsapp_number_pempek === '6281234567890') {
            $s->whatsapp_number_pempek = '6281278819911'; // Pempek Tince (0812 7881 9911)
        }

        // Google Maps: isi kalau masih kosong.
        if (! $s->maps_embed) {
            $s->maps_embed = $mapsEmbed;
        }
        if (! $s->maps_link) {
            $s->maps_link = $mapsLink;
        }

        $s->save();
    }

    public function down(): void
    {
        //
    }
};
