<?php

use App\Models\Brand;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Database\Migrations\Migration;

/**
 * Menu FIKS Pondok Tince (dari materi promosi resmi client).
 * Idempoten: kategori & item dibuat via firstOrCreate/updateOrCreate berdasarkan slug.
 * Foto diisi belakangan oleh admin (image_path dibiarkan null → placeholder rapi).
 */
return new class extends Migration
{
    public function up(): void
    {
        $brand = Brand::where('key', Brand::KEY_PONDOK)->first();

        if (! $brand) {
            return;
        }

        $categories = [
            'aneka-tumpeng' => 'Aneka Tumpeng',
            'aneka-sarapan-pagi' => 'Aneka Sarapan Pagi',
            'aneka-pindang' => 'Aneka Pindang',
            'aneka-olahan-udang' => 'Aneka Olahan Udang',
            'aneka-prasmanan' => 'Aneka Prasmanan',
        ];

        $catModels = [];
        $ci = 1;
        foreach ($categories as $slug => $name) {
            $catModels[$slug] = MenuCategory::firstOrCreate(
                ['brand_id' => $brand->id, 'slug' => $slug],
                ['name' => $name, 'is_active' => true, 'sort_order' => $ci++]
            );
        }

        // [kategori, nama, deskripsi singkat, deskripsi lengkap, favorit, best seller]
        $items = [
            ['aneka-tumpeng', 'Nasi Tumpeng', 'Nasi tumpeng lengkap untuk syukuran & acara spesial.',
                'Nasi tumpeng khas dengan aneka lauk yang lengkap — cocok untuk syukuran, ulang tahun, tasyakuran, dan acara spesial lainnya. Bisa dipesan sesuai kebutuhan dan jumlah tamu. Hubungi kami untuk konsultasi porsi & isian.', true, true],

            ['aneka-sarapan-pagi', 'Burgo', 'Sarapan khas Palembang, gulungan tepung beras berkuah santan gurih.',
                'Burgo adalah menu sarapan khas Palembang berupa lembaran tepung beras yang digulung, disiram kuah santan gurih berbumbu. Lembut, hangat, dan mengenyangkan — pas untuk memulai hari.', true, false],
            ['aneka-sarapan-pagi', 'Celimpungan', 'Bola ikan khas Palembang dengan kuah santan kuning gurih.',
                'Celimpungan berupa bola-bola ikan khas Palembang yang disiram kuah santan kuning bercita rasa gurih dan sedikit pedas. Menu sarapan pagi favorit yang bikin nagih.', true, false],

            ['aneka-pindang', 'Pindang Tulang', 'Pindang tulang berkuah segar, asam, dan pedas khas Palembang.',
                'Pindang tulang sapi dengan kuah segar berbumbu — perpaduan asam, pedas, dan gurih yang khas Palembang. Disajikan hangat, cocok dinikmati bersama nasi putih.', true, true],
            ['aneka-pindang', 'Pindang Kerupuk', 'Pindang dengan kerupuk yang menyerap kuah bumbu.',
                'Pindang kerupuk menghadirkan kerupuk yang menyerap kuah pindang berbumbu — perpaduan gurih, segar, dan tekstur yang unik khas Palembang.', false, false],
            ['aneka-pindang', 'Pindang Ikan Gabus', 'Pindang ikan gabus dengan kuah rempah yang kaya & segar.',
                'Pindang ikan gabus dengan kuah rempah yang kaya rasa, segar, dan menggugah selera. Ikannya lembut dengan bumbu yang meresap sempurna.', true, false],

            ['aneka-olahan-udang', 'Udang Goreng Mentega', 'Udang goreng mentega, saus manis-gurih yang menggoda.',
                'Udang goreng mentega dengan saus manis-gurih yang khas, disajikan dengan sayuran segar. Renyah di luar, juicy di dalam — favorit seluruh keluarga.', true, true],

            ['aneka-prasmanan', 'Prasmanan', 'Aneka pilihan lauk prasmanan khas Palembang untuk acara & rombongan.',
                'Menu prasmanan Pondok Tince menawarkan beragam pilihan lauk khas Palembang yang bisa dipilih sesuai selera. Cocok untuk acara keluarga, kantor, dan rombongan. Silakan konsultasi menu & jumlah porsi via WhatsApp.', false, true],
        ];

        $si = 1;
        foreach ($items as $it) {
            MenuItem::updateOrCreate(
                ['brand_id' => $brand->id, 'slug' => \Illuminate\Support\Str::slug($it[1])],
                [
                    'menu_category_id' => $catModels[$it[0]]->id ?? null,
                    'name' => $it[1],
                    'short_description' => $it[2],
                    'description' => $it[3],
                    'is_favorite' => $it[4],
                    'is_best_seller' => $it[5],
                    'is_available' => true,
                    'sort_order' => $si++,
                    'cta_label' => 'Pesan',
                    'wa_message_template' => 'Halo Pondok Tince, saya ingin pesan {name}. Apakah tersedia?',
                ]
            );
        }
    }

    public function down(): void
    {
        // Sengaja dibiarkan kosong agar tidak menghapus menu yang mungkin sudah
        // disunting/diberi foto oleh admin.
    }
};
