<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Konten "Keunggulan" (features) & "Cara Order" (steps) yang bisa diedit dari admin.
 * Umum untuk halaman landing (dipakai di Pempek Tince).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->json('features')->nullable()->after('intro_content');
            $table->json('steps')->nullable()->after('features');
        });

        // Isi default untuk halaman Pempek Tince agar langsung tampil & tinggal disunting.
        $features = [
            ['icon' => 'fish', 'title' => 'Ikan Berkualitas'],
            ['icon' => 'fire', 'title' => 'Rasa Khas Palembang'],
            ['icon' => 'gift', 'title' => 'Cocok untuk Oleh-Oleh'],
            ['icon' => 'chat', 'title' => 'Bisa Pesan Online'],
            ['icon' => 'snowflake', 'title' => 'Tersedia Frozen'],
        ];
        $steps = [
            ['title' => 'Pilih menu / paket'],
            ['title' => 'Klik WhatsApp'],
            ['title' => 'Konfirmasi stok & pengiriman'],
            ['title' => 'Pembayaran'],
            ['title' => 'Pesanan diproses'],
        ];

        DB::table('pages')->where('slug', 'pempek-tince')->update([
            'features' => json_encode($features),
            'steps' => json_encode($steps),
        ]);
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['features', 'steps']);
        });
    }
};
