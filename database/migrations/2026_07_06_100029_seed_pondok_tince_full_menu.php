<?php

use App\Models\Brand;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\ProductReview;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

/**
 * Menu LENGKAP & FIKS Pondok Tince (dari daftar harga resmi client, 05-05-2026).
 * Pempek → brand Pempek Tince; makanan/minuman/kue → brand Pondok Tince.
 * Mengganti seluruh menu lama (masih placeholder) dengan data real + harga.
 */
return new class extends Migration
{
    public function up(): void
    {
        $pondok = Brand::where('key', Brand::KEY_PONDOK)->first();
        $pempek = Brand::where('key', Brand::KEY_PEMPEK)->first();
        if (! $pondok || ! $pempek) {
            return;
        }

        // Bersihkan menu lama (masih placeholder) dari kedua brand.
        $oldItemIds = MenuItem::whereIn('brand_id', [$pondok->id, $pempek->id])->pluck('id');
        ProductReview::where('reviewable_type', MenuItem::class)->whereIn('reviewable_id', $oldItemIds)->delete();
        MenuItem::whereIn('brand_id', [$pondok->id, $pempek->id])->forceDelete();
        MenuCategory::whereIn('brand_id', [$pondok->id, $pempek->id])->delete();

        // [brand, [ [Kategori, [ [Nama, Harga, Catatan?], ... ] ], ... ] ]
        $data = [
            $pempek->id => [
                ['Paket Pempek', [
                    ['Paket 25 pcs', 150000], ['Paket 30 pcs', 180000], ['Paket 40 pcs', 240000],
                    ['Paket 50 pcs', 300000], ['Paket 60 pcs', 360000], ['Paket 70 pcs', 420000],
                    ['Paket 75 pcs', 450000], ['Paket 85 pcs', 510000], ['Paket 100 pcs', 600000],
                    ['Paket 125 pcs', 750000], ['Paket 250 pcs', 1500000],
                    ['1 Cap (4 Telur Besar)', 120000], ['1 Cap (5 Telur Besar)', 150000],
                    ['1 Cap (4 Lenjer Besar)', 154000], ['1 Cap (5 Lenjer Besar)', 192500],
                    ['1 Cap (Tekwan)', 150000],
                    ['Botor / Kerupuk / Kemplang Goreng', 40000], ['Kerupuk / Kemplang Panggang (Gobang)', 45000],
                ]],
                ['Aneka Pempek', [
                    ['Pistel', 6000], ['Keriting', 6000], ['Tahu', 6000], ['Lenjer Kecil', 6000],
                    ['Adaan', 6000], ['Telur Kecil', 6000], ['Pempek Panggang', 6500],
                    ['Model', 30000], ['Tekwan', 30000], ['Pempek Kapal Selam', 30000, null, true],
                    ['Rujak Mie', 30000], ['Pempek Lenggang', 30000],
                ]],
            ],
            $pondok->id => [
                ['Aneka Sarapan Pagi', [
                    ['Nasi Uduk Ayam Goreng', 30000], ['Nasi Uduk Telur', 20000], ['Lontong', 25000],
                    ['Burgo', 25000, null, true], ['Celimpungan', 25000, null, true], ['Lakso', 25000],
                ]],
                ['Bubur & Mie Ayam', [
                    ['Gohyong Ayam', 30000], ['Mie Ayam', 25000], ['Bubur Ayam', 20000], ['Bubur Abon', 20000],
                    ['Bubur Kacang Ijo', 15000], ['Telur Setengah Matang', 15000], ['Indomie Goreng Biasa', 10000],
                    ['Indomie Goreng Telur', 15000], ['Indomie Kari Ayam Biasa', 10000], ['Indomie Kari Ayam Telur', 15000],
                ]],
                ['Aneka Prasmanan', [
                    ['Nasi Minyak', 15000], ['Malbi / Rendang / Balado', 15000], ['Ayam Semur', 10000],
                    ['Ayam Kalio', 10000], ['Ayam Kare', 10000], ['Ayam Kalasan', 10000], ['Telur Kare', 7000],
                    ['Telur Kalio', 7000], ['Telur Sambal', 7000], ['Telur Asam Manis', 7000], ['Telur Semur', 7000],
                    ['Sate Ati', 10000], ['Pentul', 10000], ['Bihun', 7500], ['Mie Tumis', 7500],
                    ['Tempe Kecap', 7500], ['Tempe Bacem', 7500], ['Sayur Buncis', 7500], ['Sayur Capcai', 7500],
                    ['Perkedel', 7500], ['Sambal Cenge', 4000], ['Sambal Tempe', 4000],
                ]],
                ['Nasi Goreng, Mie & Kwetiau', [
                    ['Mie Goreng Special Ultah', 50000], ['Mie Goreng Ayam & Seafood', 35000],
                    ['Kwetiau Goreng Seafood', 45000], ['Kwetiau Goreng Sapi', 35000], ['Kwetiau Goreng Ayam', 30000],
                    ['Nasi Goreng Sapi Pete', 35000], ['Nasi Goreng Kampung', 35000, null, true],
                    ['Nasi Goreng Nanas', 30000], ['Nasi Goreng Tomyam', 30000], ['Nasi Goreng Rendang', 30000],
                    ['Nasi Goreng Dendeng', 30000], ['Nasi Goreng Malbi', 30000], ['Nasi Goreng Ati', 25000],
                    ['Nasi Goreng Polos', 25000],
                ]],
                ['Aneka Nasi Bakar', [
                    ['Nasi Bakar Rendang', 40000], ['Nasi Bakar Malbi', 40000], ['Nasi Bakar Balado / Dendeng', 40000],
                    ['Nasi Bakar Ayam Goreng', 40000], ['Nasi Bakar Cumi', 40000], ['Nasi Bakar Daging Sapi', 40000],
                    ['Nasi Bakar Udang Balado', 40000], ['Nasi Bakar Ayam Suir', 30000], ['Nasi Bakar Ati', 30000],
                    ['Nasi Bakar Polos', 20000],
                ]],
                ['Ayam', [
                    ['Sate Ayam', 40000], ['Ayam Kluyuk', 40000], ['Ayam Kungpao', 40000],
                    ['Ayam Saos Mentega', 40000], ['Ayam Bakar Saos Madu', 40000, null, true],
                    ['Ayam Lada Garam', 40000], ['Ayam Saos Lemon', 40000], ['Ayam Goreng Aceh', 40000],
                    ['Ayam Cabe Ijo', 25000], ['Ayam Bakar Bumbu Jahe', 25000], ['Ayam Bakar Bumbu Bali', 25000],
                    ['Ayam Kalasan', 25000],
                ]],
                ['Udang', [
                    ['Udang Saos Mentega', 55000, null, true], ['Udang Mayones', 55000], ['Udang Sambal Pete', 55000],
                    ['Udang Saos Thai', 55000], ['Udang Telor Asin', 55000], ['Udang Lada Garam', 55000],
                    ['Udang Benang Mas', 55000],
                ]],
                ['Cumi', [
                    ['Cumi Saos Padang', 50000], ['Cumi Saos Thai', 50000], ['Cumi Bakar Bumbu Bali', 50000],
                    ['Cumi Bakar Saos Madu', 50000], ['Cumi Bakar Bumbu Jahe', 50000], ['Cumi Lada Garam', 50000],
                    ['Cumi Saos Asam Manis', 50000], ['Cumi Crispy', 50000], ['Cumi Pedas Manis', 50000],
                ]],
                ['Ikan', [
                    ['Ikan Gabus Dabu Dabu', 65000], ['Gurami Saos Pedas Manis', 80000, '80k – 100k'],
                    ['Gurami Saos Padang', 80000, '80k – 100k'], ['Gurami Saos Madu', 80000, '80k – 100k'],
                    ['Gurami Bakar Bumbu Bali', 80000, '80k – 100k', true], ['Gurami Bakar Bumbu Jahe', 80000, '80k – 100k'],
                    ['Gurami Goreng Terbang', 80000, '80k – 100k'], ['Ikan Filet Saos Pedas Manis', 40000],
                    ['Ikan Filet Saos Padang', 40000], ['Ikan Filet Saos Madu', 40000],
                    ['Ikan Filet Bakar Bumbu Bali', 40000], ['Ikan Filet Bakar Bumbu Jahe', 40000],
                ]],
                ['Sup & Soto', [
                    ['Soto Daging', 50000], ['Sup Daging', 50000], ['Sup Tomyam', 50000], ['Rawon', 50000],
                    ['Sup Ayam', 35000], ['Soto Ayam', 35000], ['Sup Asparagus', 30000], ['Sup Jagung Ayam', 30000],
                ]],
                ['Pindang & Brengkes', [
                    ['Pindang Tulang', 60000, null, true], ['Pindang Ikan Gabus', 50000], ['Pindang Patin', 30000],
                    ['Pindang Ayam', 30000], ['Pindang Kerupuk', 25000], ['Pindang Otak Otak Singapore', 25000],
                    ['Brengkes Udang Tempoyak', 55000], ['Brengkes Gabus Tempoyak', 45000],
                    ['Brengkes Patin Tempoyak', 50000], ['Brengkes Ikan Pedo', 25000],
                ]],
                ['Aneka Sayuran', [
                    ['Buncis Tumis Ala Szechuan', 45000], ['Buncis Cah Udang', 40000], ['Brokoli Cah Sapi', 40000],
                    ['Brokoli Jamur Sintake', 35000], ['Brokoli Cah Sari Laut', 35000], ['Brokoli Bawang Putih', 30000],
                    ['Toge Ikan Asin', 30000], ['Capcay', 30000], ['Kangkung Bawang Putih', 30000],
                    ['Kangkung Balacan', 30000], ['Buncis Goreng', 30000],
                ]],
                ['Aneka Roti Bakar', [
                    ['Roti Bakar Coklat', 25000], ['Roti Bakar Coklat Keju', 25000], ['Roti Bakar Keju Susu', 25000],
                    ['Roti Bakar Mentega Gula', 25000],
                ]],
                ['Snack', [
                    ['Pisang Goreng', 25000], ['Cakwe Isi Udang', 25000], ['Cakwe Biasa', 15000],
                    ['Sayap Ayam BBQ (Isi 3)', 20000], ['Ubi Goreng', 15000], ['Nugget', 15000], ['Kentang Goreng', 15000],
                ]],
                ['Aneka Jajanan Pasar', [
                    ['Sus Coklat', 6000], ['Sus Vanila', 5000], ['Lupis', 5000], ['Dadar Jiwa', 5000],
                    ['Klepon', 4000], ['Cenil', 4000], ['Lemper', 4000], ['Risol', 4000], ['Ongol-Ongol', 4000], ['Gandus', 4000],
                ]],
                ['Aneka Kue Basah', [
                    ['Lapis Legit', 24000], ['Mak Suba', 24000], ['Kojo', 24000], ['Engkak Ketan', 24000], ['Kue 8 Jam', 24000],
                ]],
                ['Juice', [
                    ['Juice Banana Strawberry', 35000], ['Mix Juice', 35000], ['Juice Manggo', 35000], ['Juice Strawberry', 30000],
                    ['Juice Kiwi', 25000], ['Juice Banana', 25000], ['Es Jeruk Murni', 25000], ['Juice Soursop (Sirsak)', 25000],
                    ['Juice Kacang Ijo', 25000], ['Juice Dragonfruit', 25000], ['Juice Watermelon', 25000],
                    ['Juice Pineapple', 25000], ['Juice Tomato', 25000], ['Juice Carrot', 25000], ['Juice HoneyDew', 25000],
                    ['Juice Avocado', 25000],
                ]],
                ['Tea', [
                    ['Thai Tea', 25000], ['Green Tea', 25000], ['Teh Tarik', 25000], ['Chinese Tea', 20000],
                    ['Lemon Tea', 20000], ['Lime Ice / Hot', 17000], ['Chi Hua Chi', 17000], ['Sweet Tea', 8000],
                    ['Ice Tea', 7000], ['Air Putih', 3000],
                ]],
                ['Milkshake', [
                    ['Milkshake Avocado', 20000], ['Milkshake Oreo', 20000], ['Milkshake Strawberry', 20000],
                    ['Milkshake Banana', 20000], ['Milkshake Matcha', 20000], ['Milkshake Redvelvet', 20000],
                    ['Milkshake Taro', 20000], ['Milkshake Milo', 20000], ['Milkshake Vanilla', 20000], ['Milkshake Chocolate', 20000],
                ]],
                ['Flavours Tea', [
                    ['Peach Tea', 20000], ['Lychee Tea', 20000], ['Manggo Tea', 20000], ['Strawberry Tea', 20000], ['Kiwi Tea', 20000],
                ]],
                ['Coffee', [
                    ['Cappucino Vanilla / Caramel', 25000, 'Ice / Hot'], ['Coffee Latte Vanilla / Mint', 25000, 'Ice / Hot'],
                    ['Cappucino Hazelnut / Mint', 25000, 'Ice / Hot'], ['Coffee Latte Hazelnut / Caramel', 25000, 'Ice / Hot'],
                    ['Aren Latte', 25000], ['Coffee Latte / Mochacino', 25000, 'Ice / Hot'], ['Cappucino', 25000, 'Ice / Hot'],
                    ['Americano', 20000, 'Ice / Hot'], ['Vietnam Drip', 20000], ['Tubruk', 20000],
                    ['Espresso Double Shot', 25000], ['Espresso Single Shot', 15000],
                ]],
                ['Squash', [
                    ['Kiwi Mint', 25000], ['Manggo Mint', 25000], ['Peach Squash', 25000], ['Orange Squash', 25000],
                    ['Strawberry Squash', 25000], ['Lime Squash', 20000],
                ]],
                ['Minuman Lainnya', [
                    ['Es Kacang Merah', 25000], ['Es Alpokad Kocok', 25000], ['Es Campur', 30000], ['Hazelnut Kacang Ijo', 25000],
                    ['Bandrek', 20000], ['Susu Sari Kacang Ijo', 20000], ['Mineral Water 600 ml', 8000], ['Mineral Water 330 ml', 5000],
                ]],
            ],
        ];

        foreach ($data as $brandId => $categories) {
            $ci = 1;
            foreach ($categories as [$catName, $items]) {
                $catSlug = Str::slug($catName);
                $category = MenuCategory::create([
                    'brand_id' => $brandId,
                    'name' => $catName,
                    'slug' => $catSlug,
                    'is_active' => true,
                    'sort_order' => $ci++,
                ]);

                $si = 1;
                foreach ($items as $item) {
                    [$name, $price] = $item;
                    $note = $item[2] ?? null;
                    $fav = $item[3] ?? false;

                    MenuItem::create([
                        'brand_id' => $brandId,
                        'menu_category_id' => $category->id,
                        'name' => $name,
                        'slug' => Str::slug($catSlug.' '.$name),
                        'price' => $price,
                        'price_note' => $note,
                        'is_available' => true,
                        'is_favorite' => $fav,
                        'is_best_seller' => $fav,
                        'sort_order' => $si++,
                        'cta_label' => 'Pesan',
                        'wa_message_template' => 'Halo Pondok Tince, saya ingin pesan {name}. Apakah tersedia?',
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        // Tidak menghapus agar menu yang mungkin sudah disunting admin tetap aman.
    }
};
