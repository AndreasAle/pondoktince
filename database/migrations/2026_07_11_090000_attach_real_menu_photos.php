<?php

use App\Models\Brand;
use App\Models\Gallery;
use App\Models\MenuItem;
use Illuminate\Database\Migrations\Migration;

/**
 * Pasang foto asli makanan (di-commit ke public/img/menu) ke menu item + galeri home.
 * Idempotent: aman dijalankan ulang saat deploy.
 */
return new class extends Migration
{
    public function up(): void
    {
        // slug menu item => path foto (relatif ke public/)
        $map = [
            'ayam-ayam-bakar-saos-madu' => 'img/menu/ayam-ayam-bakar-saos-madu.jpg',
            'ayam-ayam-cabe-ijo' => 'img/menu/ayam-ayam-cabe-ijo.jpg',
            'ayam-ayam-goreng-aceh' => 'img/menu/ayam-ayam-goreng-aceh.jpg',
            'ayam-ayam-saos-mentega' => 'img/menu/ayam-ayam-saos-mentega.jpg',
            'ayam-ayam-kalasan' => 'img/menu/ayam-ayam-kalasan.jpg',
            'ayam-ayam-kluyuk' => 'img/menu/ayam-ayam-kluyuk.jpg',
            'ayam-ayam-lada-garam' => 'img/menu/ayam-ayam-lada-garam.jpg',
            'ayam-ayam-saos-lemon' => 'img/menu/ayam-ayam-saos-lemon.jpg',
            'cumi-cumi-bakar-bumbu-bali' => 'img/menu/cumi-cumi-bakar-bumbu-bali.jpg',
            'cumi-cumi-bakar-bumbu-jahe' => 'img/menu/cumi-cumi-bakar-bumbu-jahe.jpg',
            'aneka-kue-basah-kue-8-jam' => 'img/menu/aneka-kue-basah-kue-8-jam.jpg',
            'aneka-jajanan-pasar-cenil' => 'img/menu/aneka-jajanan-pasar-cenil.jpg',
            'aneka-jajanan-pasar-dadar-jiwa' => 'img/menu/aneka-jajanan-pasar-dadar-jiwa.jpg',
            'aneka-pempek-model' => 'img/menu/aneka-pempek-model.jpg',
            'aneka-pempek-adaan' => 'img/menu/aneka-pempek-adaan.jpg',
            'aneka-pempek-keriting' => 'img/menu/aneka-pempek-keriting.jpg',
            'aneka-pempek-pempek-lenggang' => 'img/menu/aneka-pempek-pempek-lenggang.jpg',
            'aneka-pempek-lenjer-kecil' => 'img/menu/aneka-pempek-lenjer-kecil.jpg',
            'aneka-pempek-pempek-panggang' => 'img/menu/aneka-pempek-pempek-panggang.jpg',
            'aneka-pempek-pistel' => 'img/menu/aneka-pempek-pistel.jpg',
            'aneka-pempek-pempek-kapal-selam' => 'img/menu/aneka-pempek-pempek-kapal-selam.jpg',
            'aneka-pempek-telur-kecil' => 'img/menu/aneka-pempek-telur-kecil.jpg',
            'aneka-pempek-tekwan' => 'img/menu/aneka-pempek-tekwan.jpg',
            'aneka-pempek-tahu' => 'img/menu/aneka-pempek-tahu.jpg',
            'aneka-pempek-rujak-mie' => 'img/menu/aneka-pempek-rujak-mie.jpg',
            'pindang-brengkes-brengkes-gabus-tempoyak' => 'img/menu/pindang-brengkes-brengkes-gabus-tempoyak.jpg',
            'pindang-brengkes-brengkes-patin-tempoyak' => 'img/menu/pindang-brengkes-brengkes-patin-tempoyak.jpg',
            'pindang-brengkes-pindang-ikan-gabus' => 'img/menu/pindang-brengkes-pindang-ikan-gabus.jpg',
            'pindang-brengkes-pindang-kerupuk' => 'img/menu/pindang-brengkes-pindang-kerupuk.jpg',
            'pindang-brengkes-pindang-otak-otak-singapore' => 'img/menu/pindang-brengkes-pindang-otak-otak-singapore.jpg',
            'pindang-brengkes-pindang-patin' => 'img/menu/pindang-brengkes-pindang-patin.jpg',
            'pindang-brengkes-pindang-tulang' => 'img/menu/pindang-brengkes-pindang-tulang.jpg',
            'aneka-roti-bakar-roti-bakar-coklat' => 'img/menu/aneka-roti-bakar-roti-bakar-coklat.jpg',
            'aneka-roti-bakar-roti-bakar-coklat-keju' => 'img/menu/aneka-roti-bakar-roti-bakar-coklat-keju.jpg',
            'aneka-roti-bakar-roti-bakar-keju-susu' => 'img/menu/aneka-roti-bakar-roti-bakar-keju-susu.jpg',
            'aneka-roti-bakar-roti-bakar-mentega-gula' => 'img/menu/aneka-roti-bakar-roti-bakar-mentega-gula.jpg',
            'paket-pempek-paket-25-pcs' => 'img/menu/paket-pempek-paket-25-pcs.jpg',
            'paket-pempek-paket-50-pcs' => 'img/menu/paket-pempek-paket-50-pcs.jpg',
            'paket-pempek-paket-100-pcs' => 'img/menu/paket-pempek-paket-100-pcs.jpg',
            'paket-pempek-1-cap-4-lenjer-besar' => 'img/menu/paket-pempek-1-cap-4-lenjer-besar.jpg',
            'paket-pempek-1-cap-5-lenjer-besar' => 'img/menu/paket-pempek-1-cap-5-lenjer-besar.jpg',
        ];

        foreach ($map as $slug => $path) {
            MenuItem::where('slug', $slug)->update(['image_path' => $path]);
        }

        // Galeri homepage — foto aneka hidangan (idempotent).
        $pempekBrand = Brand::where('slug', 'pempek-tince')->value('id');
        $galleries = [
            ['img/gallery/pt-01.jpg', 'Aneka pempek Palembang Pempek Tince'],
            ['img/gallery/pt-02.jpg', 'Pempek kapal selam & telur asli Pempek Tince'],
            ['img/gallery/pt-03.jpg', 'Pempek Palembang homemade Pempek Tince'],
            ['img/gallery/pt-04.jpg', 'Aneka pempek Tince siap saji'],
            ['img/gallery/pt-05.jpg', 'Pempek Palembang lengkap dengan cuko'],
            ['img/gallery/pt-06.jpg', 'Pilihan pempek Pempek Tince'],
            ['img/gallery/pt-07.jpg', 'Ayam asam manis Pondok Tince'],
            ['img/gallery/pt-08.jpg', 'Ayam dabu dabu khas Pondok Tince'],
        ];

        foreach ($galleries as $i => [$path, $alt]) {
            Gallery::firstOrCreate(
                ['image_path' => $path],
                [
                    'brand_id' => $pempekBrand,
                    'category' => 'Kuliner',
                    'alt_text' => $alt,
                    'caption' => $alt,
                    'is_active' => true,
                    'sort_order' => $i + 1,
                ]
            );
        }
    }

    public function down(): void
    {
        //
    }
};
