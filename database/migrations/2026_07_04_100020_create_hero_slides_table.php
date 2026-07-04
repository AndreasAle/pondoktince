<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();          // teks kecil di atas judul
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('image_path')->nullable();        // background slide
            $table->string('image_alt')->nullable();

            $table->string('primary_label')->nullable();     // tombol 1 (emas)
            $table->string('primary_url')->nullable();
            $table->string('secondary_label')->nullable();   // tombol 2 (outline)
            $table->string('secondary_url')->nullable();

            $table->boolean('show_whatsapp')->default(true); // tombol WhatsApp ter-track
            $table->string('whatsapp_message', 500)->nullable();

            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });

        // Dua slide default agar carousel langsung hidup (client tinggal ganti gambar & teks).
        DB::table('hero_slides')->insert([
            [
                'eyebrow' => 'Selamat Datang di Pondok Tince',
                'title' => 'Rasa Rumahan Khas Palembang, Disajikan Istimewa',
                'subtitle' => 'Pondok Tince menghadirkan kehangatan masakan Palembang untuk keluarga, tamu luar kota, dan acara spesial.',
                'image_path' => null,
                'primary_label' => 'Lihat Menu Kami',
                'primary_url' => '/menu',
                'secondary_label' => 'Pesan Pempek Tince',
                'secondary_url' => '/pempek-tince',
                'show_whatsapp' => true,
                'whatsapp_message' => 'Halo Pondok Tince, saya ingin booking tempat.',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'eyebrow' => 'Cita Rasa untuk Keluarga',
                'title' => 'Tempat Makan Nyaman untuk Acara & Rombongan',
                'subtitle' => 'Arisan, meeting kantor, hingga menjamu tamu luar kota — semua terasa hangat di Pondok Tince.',
                'image_path' => null,
                'primary_label' => 'Lihat Paket Acara',
                'primary_url' => '/paket-acara',
                'secondary_label' => 'Booking Tempat',
                'secondary_url' => '/booking',
                'show_whatsapp' => true,
                'whatsapp_message' => 'Halo Pondok Tince, saya ingin konsultasi acara.',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
