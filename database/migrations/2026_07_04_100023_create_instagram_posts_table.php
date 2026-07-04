<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instagram_posts', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();     // foto konten IG (upload)
            $table->string('image_alt')->nullable();
            $table->text('caption')->nullable();
            $table->string('permalink')->nullable();       // link ke postingan IG asli
            $table->string('brand_key')->nullable();       // pondok-tince | pempek-tince | null (umum)
            $table->boolean('is_reel')->default(false);    // tampilkan ikon reel/video
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });

        // Contoh awal agar section langsung terlihat (client tinggal ganti foto & link).
        $now = now();
        $rows = [];
        for ($i = 1; $i <= 6; $i++) {
            $rows[] = [
                'image_path' => null,
                'caption' => 'Momen di Pondok Tince — ganti dengan konten Instagram asli Anda.',
                'permalink' => 'https://www.instagram.com/pondoktince.plg/',
                'brand_key' => $i % 3 === 0 ? 'pempek-tince' : 'pondok-tince',
                'is_reel' => $i % 4 === 0,
                'is_active' => true,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('instagram_posts')->insert($rows);
    }

    public function down(): void
    {
        Schema::dropIfExists('instagram_posts');
    }
};
