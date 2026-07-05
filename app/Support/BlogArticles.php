<?php

namespace App\Support;

/**
 * Kumpulan artikel SEO (fokus keyword pempek Palembang) untuk mengangkat
 * peringkat organik. Di-seed lewat migration agar otomatis terbit saat deploy.
 * Konten bisa disunting kembali dari admin (Filament > Artikel).
 */
class BlogArticles
{
    /** @return array<int,array<string,mixed>> */
    public static function all(): array
    {
        $cta = '<h2>Pesan Pempek Palembang di Pempek Tince</h2>'
            .'<p>Ingin menikmati pempek Palembang yang enak dan berkualitas? <a href="/pempek-tince">Pempek Tince</a> menyediakan aneka '
            .'<a href="/pempek-tince/menu">varian pempek</a>, <a href="/pempek-tince/paket-pempek">paket pempek</a>, hingga '
            .'<a href="/pempek-tince/pempek-frozen">pempek frozen</a> yang bisa dikirim ke luar kota. Pesan mudah lewat WhatsApp — '
            .'kunjungi halaman <a href="/pempek-palembang">Pempek Palembang</a> untuk memesan sekarang.</p>';

        return [
            [
                'slug' => 'sejarah-pempek-palembang',
                'title' => 'Sejarah Pempek Palembang: Asal Usul Kuliner Legendaris Ini',
                'category' => 'pempek',
                'keyword' => 'sejarah pempek Palembang',
                'excerpt' => 'Mengenal sejarah pempek Palembang, dari asal usulnya hingga menjadi ikon kuliner Sumatera Selatan yang mendunia.',
                'meta_title' => 'Sejarah Pempek Palembang: Asal Usul & Fakta Menariknya',
                'meta_description' => 'Kenali sejarah pempek Palembang, asal usul namanya, dan alasan kuliner khas Sumatera Selatan ini begitu melegenda. Pesan pempek asli di Pempek Tince.',
                'reading_time' => 5,
                'content' => '<p><strong>Pempek Palembang</strong> adalah salah satu kuliner paling ikonik dari Sumatera Selatan. Perpaduan ikan dan sagu yang kenyal, disajikan dengan cuko yang asam, pedas, dan manis, membuat pempek dicintai lintas generasi. Tapi tahukah Anda bagaimana sejarah pempek Palembang bermula?</p>'
                    .'<h2>Asal Usul Nama "Pempek"</h2>'
                    .'<p>Ada beberapa versi mengenai asal usul nama pempek. Versi yang paling populer menyebutkan bahwa makanan ini dijajakan oleh seorang pedagang keturunan Tionghoa yang kerap dipanggil "apek" atau "empek". Dari sanalah nama "empek-empek" — yang kemudian populer sebagai pempek — berasal.</p>'
                    .'<h2>Pengaruh Sungai Musi dan Kekayaan Ikan</h2>'
                    .'<p>Palembang dikenal dengan Sungai Musi yang kaya akan ikan, terutama ikan belida dan gabus. Melimpahnya hasil sungai inilah yang mendorong masyarakat mengolah ikan menjadi berbagai sajian, salah satunya pempek. Kombinasi ikan giling dan sagu menghasilkan tekstur khas yang tidak ditemukan di daerah lain.</p>'
                    .'<h2>Pempek dari Masa ke Masa</h2>'
                    .'<p>Seiring waktu, pempek berkembang menjadi banyak varian — dari <a href="/pempek-palembang">pempek kapal selam</a> berisi telur, lenjer yang panjang, hingga adaan yang gurih. Kini pempek tidak hanya dinikmati di Palembang, tetapi juga dikirim ke seluruh Indonesia sebagai oleh-oleh maupun stok frozen.</p>'
                    .'<h2>Pempek sebagai Identitas Kuliner Palembang</h2>'
                    .'<p>Hari ini, pempek telah menjadi identitas kuliner Palembang. Hampir setiap sudut kota menjual pempek, dan wisatawan pun menjadikannya buruan utama. Cita rasa autentik dengan ikan berkualitas tetap menjadi kunci pempek yang enak.</p>'
                    .$cta,
            ],
            [
                'slug' => 'jenis-jenis-pempek-palembang',
                'title' => 'Jenis-Jenis Pempek Palembang yang Wajib Dicoba',
                'category' => 'pempek',
                'keyword' => 'jenis pempek Palembang',
                'excerpt' => 'Dari kapal selam hingga adaan, kenali jenis-jenis pempek Palembang beserta ciri khas rasanya masing-masing.',
                'meta_title' => 'Jenis-Jenis Pempek Palembang yang Wajib Dicoba',
                'meta_description' => 'Panduan lengkap jenis pempek Palembang: kapal selam, lenjer, adaan, kulit, dan lainnya. Temukan favorit Anda dan pesan di Pempek Tince.',
                'reading_time' => 6,
                'content' => '<p>Banyak yang mengira pempek hanya satu jenis. Padahal, <strong>pempek Palembang</strong> punya banyak varian dengan bentuk, isi, dan rasa yang berbeda-beda. Berikut jenis pempek Palembang yang paling populer dan wajib Anda coba.</p>'
                    .'<h2>1. Pempek Kapal Selam</h2>'
                    .'<p>Inilah varian paling ikonik. Pempek kapal selam berukuran besar dengan isian telur ayam utuh di dalamnya. Perpaduan gurihnya adonan ikan dan lembutnya telur membuatnya jadi favorit sepanjang masa.</p>'
                    .'<h2>2. Pempek Lenjer</h2>'
                    .'<p>Pempek lenjer berbentuk panjang seperti silinder. Ini adalah "bentuk dasar" pempek yang biasanya dipotong-potong sebelum disantap. Teksturnya kenyal dan padat.</p>'
                    .'<h2>3. Pempek Adaan</h2>'
                    .'<p>Berbeda dari yang lain, pempek adaan berbentuk bulat dan langsung digoreng tanpa direbus dulu. Rasanya lebih gurih karena adonannya dicampur santan dan bawang.</p>'
                    .'<h2>4. Pempek Kulit</h2>'
                    .'<p>Dibuat dari kulit ikan, pempek kulit punya rasa ikan yang lebih kuat dan tekstur yang sedikit renyah di luar. Cocok untuk pencinta rasa ikan yang pekat.</p>'
                    .'<h2>5. Pempek Telur Kecil</h2>'
                    .'<p>Versi mungil dari kapal selam, pempek telur kecil pas untuk cemilan. Praktis dan tetap nikmat dengan siraman cuko.</p>'
                    .'<p>Ingin mencoba semua varian di atas? Lihat <a href="/pempek-tince/menu">menu Pempek Tince</a> atau langsung ke halaman <a href="/pempek-palembang">Pempek Palembang</a>.</p>'
                    .$cta,
            ],
            [
                'slug' => 'cara-membuat-cuko-pempek-palembang',
                'title' => 'Cara Membuat Cuko Pempek Palembang yang Enak dan Autentik',
                'category' => 'pempek',
                'keyword' => 'cuko pempek',
                'excerpt' => 'Cuko adalah jiwa pempek. Simak cara membuat cuko pempek Palembang yang asam, pedas, dan manisnya pas.',
                'meta_title' => 'Cara Membuat Cuko Pempek Palembang yang Enak & Autentik',
                'meta_description' => 'Resep dan tips membuat cuko pempek Palembang yang autentik — perpaduan gula merah, cabai, bawang, dan asam yang pas. Cicipi cuko khas Pempek Tince.',
                'reading_time' => 6,
                'content' => '<p>Tanpa cuko, pempek terasa hambar. <strong>Cuko pempek</strong> adalah kuah berwarna cokelat pekat dengan rasa asam, pedas, dan manis yang menjadi ciri khas pempek Palembang. Berikut gambaran cara membuat cuko yang autentik.</p>'
                    .'<h2>Bahan Utama Cuko Pempek</h2>'
                    .'<ul><li>Gula merah (gula aren) berkualitas</li><li>Cabai rawit sesuai selera</li><li>Bawang putih</li><li>Asam jawa</li><li>Air dan sedikit garam</li></ul>'
                    .'<h2>Langkah Membuat Cuko</h2>'
                    .'<p>Rebus gula merah bersama air hingga larut, lalu saring agar bersih. Haluskan bawang putih dan cabai, kemudian masukkan ke rebusan gula. Tambahkan asam jawa dan garam. Masak hingga mendidih dan aromanya harum. Cuko yang baik memiliki keseimbangan rasa: manis dari gula, pedas dari cabai, dan segar dari asam.</p>'
                    .'<h2>Tips agar Cuko Lebih Enak</h2>'
                    .'<p>Gunakan gula aren asli untuk warna dan aroma yang khas. Diamkan cuko beberapa jam agar rasanya menyatu. Semakin lama, rasa cuko biasanya semakin mantap.</p>'
                    .'<h2>Tidak Sempat Membuat Sendiri?</h2>'
                    .'<p>Membuat cuko butuh waktu dan ketelatenan. Jika Anda ingin menikmati pempek dengan cuko autentik tanpa repot, <a href="/pempek-tince">Pempek Tince</a> menyediakan pempek lengkap dengan cuko khas Palembang yang sudah teruji rasanya.</p>'
                    .$cta,
            ],
            [
                'slug' => 'pempek-frozen-cara-simpan-goreng',
                'title' => 'Pempek Frozen: Cara Menyimpan dan Menggoreng agar Tetap Enak',
                'category' => 'pempek',
                'keyword' => 'pempek frozen',
                'excerpt' => 'Pempek frozen praktis untuk stok di rumah. Ini cara menyimpan dan menggorengnya agar rasanya tetap seperti baru.',
                'meta_title' => 'Pempek Frozen: Cara Simpan & Goreng agar Tetap Enak',
                'meta_description' => 'Tips menyimpan dan menggoreng pempek frozen agar tetap kenyal dan enak. Pesan pempek frozen Palembang berkualitas di Pempek Tince, bisa kirim luar kota.',
                'reading_time' => 5,
                'content' => '<p><strong>Pempek frozen</strong> adalah solusi praktis untuk menikmati pempek Palembang kapan saja. Cukup simpan di freezer, lalu goreng saat ingin menyantapnya. Namun agar rasanya tetap enak, ada beberapa hal yang perlu diperhatikan.</p>'
                    .'<h2>Cara Menyimpan Pempek Frozen</h2>'
                    .'<p>Simpan pempek dalam wadah tertutup atau kemasan kedap udara di dalam freezer. Dengan penyimpanan yang benar, pempek frozen bisa bertahan lama tanpa mengurangi kualitas rasa. Hindari membiarkan pempek terlalu lama di suhu ruang sebelum kembali dibekukan.</p>'
                    .'<h2>Cara Menggoreng Pempek Frozen</h2>'
                    .'<p>Tidak perlu menunggu pempek benar-benar mencair. Panaskan minyak yang cukup banyak dengan api sedang, lalu goreng pempek langsung dari freezer. Goreng hingga permukaannya kecokelatan dan matang merata. Api yang terlalu besar bisa membuat luar gosong tapi dalam masih dingin.</p>'
                    .'<h2>Kenapa Pilih Pempek Frozen?</h2>'
                    .'<ul><li>Tahan lama, cocok untuk stok di rumah</li><li>Praktis, tinggal goreng sendiri</li><li>Bisa dikirim ke luar kota untuk keluarga</li></ul>'
                    .'<p>Butuh pempek frozen berkualitas? <a href="/pempek-tince/pempek-frozen">Pempek Frozen Pempek Tince</a> dibuat dari ikan pilihan dan bisa dikirim ke berbagai kota.</p>'
                    .$cta,
            ],
            [
                'slug' => 'oleh-oleh-khas-palembang-pempek',
                'title' => 'Pempek, Oleh-Oleh Khas Palembang yang Selalu Dicari',
                'category' => 'pempek',
                'keyword' => 'oleh-oleh khas Palembang',
                'excerpt' => 'Berkunjung ke Palembang belum lengkap tanpa membawa pempek. Ini alasan pempek jadi oleh-oleh khas Palembang favorit.',
                'meta_title' => 'Pempek, Oleh-Oleh Khas Palembang yang Selalu Dicari',
                'meta_description' => 'Pempek adalah oleh-oleh khas Palembang paling populer. Praktis dibawa pulang & bisa dikirim. Pesan pempek oleh-oleh di Pempek Tince.',
                'reading_time' => 5,
                'content' => '<p>Setiap kali orang berkunjung ke Palembang, ada satu buah tangan yang hampir selalu masuk daftar: pempek. Sebagai <strong>oleh-oleh khas Palembang</strong>, pempek punya daya tarik yang sulit ditolak. Kenapa begitu?</p>'
                    .'<h2>Rasa yang Universal</h2>'
                    .'<p>Pempek disukai hampir semua kalangan. Perpaduan gurihnya ikan dan cuko yang segar membuatnya cocok di lidah banyak orang — dari anak-anak hingga dewasa.</p>'
                    .'<h2>Praktis Dibawa dan Dikirim</h2>'
                    .'<p>Pempek mudah dikemas untuk perjalanan. Bahkan dengan opsi <a href="/pempek-tince/pempek-frozen">frozen</a>, pempek bisa dikirim ke luar kota tanpa khawatir cepat basi. Ini membuatnya ideal sebagai oleh-oleh untuk keluarga dan kerabat.</p>'
                    .'<h2>Identik dengan Palembang</h2>'
                    .'<p>Membawa pempek sebagai oleh-oleh sama dengan membawa "rasa Palembang" itu sendiri. Tidak heran jika pempek selalu jadi pilihan utama dibanding oleh-oleh lain.</p>'
                    .'<h2>Pilih Pempek Oleh-Oleh yang Berkualitas</h2>'
                    .'<p>Agar oleh-oleh Anda berkesan, pilih pempek dari ikan berkualitas dengan cuko yang autentik. <a href="/pempek-tince/oleh-oleh-palembang">Pempek Tince</a> menyediakan paket oleh-oleh yang dikemas rapi dan siap dibawa pulang.</p>'
                    .$cta,
            ],
            [
                'slug' => 'perbedaan-pempek-kapal-selam-lenjer-adaan-kulit',
                'title' => 'Beda Pempek Kapal Selam, Lenjer, Adaan, dan Kulit',
                'category' => 'pempek',
                'keyword' => 'pempek kapal selam',
                'excerpt' => 'Sering bingung membedakan jenis pempek? Simak perbedaan pempek kapal selam, lenjer, adaan, dan kulit di sini.',
                'meta_title' => 'Beda Pempek Kapal Selam, Lenjer, Adaan & Kulit',
                'meta_description' => 'Pahami perbedaan pempek kapal selam, lenjer, adaan, dan kulit dari bentuk, isi, hingga rasanya. Coba semuanya di Pempek Tince.',
                'reading_time' => 5,
                'content' => '<p>Bagi yang baru mengenal pempek, membedakan jenisnya bisa membingungkan. Padahal tiap varian punya karakter sendiri. Yuk pahami perbedaan <strong>pempek kapal selam</strong>, lenjer, adaan, dan kulit.</p>'
                    .'<h2>Pempek Kapal Selam: Si Besar Berisi Telur</h2>'
                    .'<p>Ukurannya paling besar dan berisi telur ayam utuh. Cocok untuk yang ingin porsi mengenyangkan dengan sensasi gurih-lembut.</p>'
                    .'<h2>Pempek Lenjer: Bentuk Klasik Memanjang</h2>'
                    .'<p>Berbentuk silinder panjang, biasanya dipotong sebelum disajikan. Teksturnya padat dan kenyal — inilah bentuk dasar pempek.</p>'
                    .'<h2>Pempek Adaan: Bulat dan Gurih</h2>'
                    .'<p>Berbentuk bulat dan langsung digoreng. Adonannya dicampur santan dan bumbu, membuat rasanya lebih gurih dibanding lainnya.</p>'
                    .'<h2>Pempek Kulit: Rasa Ikan yang Kuat</h2>'
                    .'<p>Dibuat dari kulit ikan, teksturnya sedikit renyah dengan rasa ikan yang pekat. Favorit para pencinta rasa ikan.</p>'
                    .'<p>Mau mencicipi bedanya langsung? Lihat <a href="/pempek-tince/menu">varian pempek di Pempek Tince</a>.</p>'
                    .$cta,
            ],
            [
                'slug' => 'tips-memilih-pempek-palembang-berkualitas',
                'title' => 'Tips Memilih Pempek Palembang yang Berkualitas dan Enak',
                'category' => 'pempek',
                'keyword' => 'pempek Palembang enak',
                'excerpt' => 'Tidak semua pempek sama. Ini tips memilih pempek Palembang yang berkualitas, kenyal, dan benar-benar enak.',
                'meta_title' => 'Tips Memilih Pempek Palembang yang Berkualitas & Enak',
                'meta_description' => 'Cara memilih pempek Palembang yang enak: perhatikan kadar ikan, tekstur, dan cuko. Pesan pempek berkualitas di Pempek Tince.',
                'reading_time' => 5,
                'content' => '<p>Mencari <strong>pempek Palembang enak</strong> memang gampang-gampang susah. Banyak pempek di pasaran, tapi tidak semuanya berkualitas. Berikut tips memilih pempek yang benar-benar enak.</p>'
                    .'<h2>1. Perhatikan Kadar Ikannya</h2>'
                    .'<p>Pempek berkualitas menggunakan ikan dalam porsi yang cukup, bukan didominasi tepung. Rasa ikan yang terasa adalah tanda pempek yang baik.</p>'
                    .'<h2>2. Tekstur yang Kenyal, Bukan Keras</h2>'
                    .'<p>Pempek yang enak memiliki tekstur kenyal dan lembut, tidak keras atau alot. Ini menunjukkan komposisi ikan dan sagu yang seimbang.</p>'
                    .'<h2>3. Cuko yang Seimbang</h2>'
                    .'<p>Cuko adalah penentu. Cuko yang enak memadukan manis, pedas, dan asam secara pas. Cuko yang terlalu encer atau terlalu manis bisa mengurangi kenikmatan.</p>'
                    .'<h2>4. Kebersihan dan Kesegaran</h2>'
                    .'<p>Pastikan pempek dibuat higienis dan segar. Untuk stok jangka panjang, pilih opsi <a href="/pempek-tince/pempek-frozen">frozen</a> yang tetap menjaga kualitas.</p>'
                    .'<p>Ingin pempek yang sudah teruji kualitasnya? <a href="/pempek-palembang">Pempek Tince</a> menggunakan ikan pilihan untuk rasa yang autentik.</p>'
                    .$cta,
            ],
            [
                'slug' => 'paket-pempek-untuk-acara-rombongan',
                'title' => 'Paket Pempek untuk Acara & Rombongan: Praktis dan Hemat',
                'category' => 'pempek',
                'keyword' => 'paket pempek',
                'excerpt' => 'Mengadakan acara? Paket pempek jadi pilihan praktis dan hemat untuk keluarga, kantor, hingga rombongan.',
                'meta_title' => 'Paket Pempek untuk Acara & Rombongan: Praktis & Hemat',
                'meta_description' => 'Paket pempek Palembang untuk acara keluarga, kantor, dan rombongan. Praktis, hemat, dan bisa dipesan online. Cek paket pempek di Pempek Tince.',
                'reading_time' => 4,
                'content' => '<p>Menyiapkan hidangan untuk acara sering bikin repot. <strong>Paket pempek</strong> bisa jadi solusi praktis yang disukai banyak orang — cocok untuk arisan, acara keluarga, hingga rombongan kantor.</p>'
                    .'<h2>Kenapa Paket Pempek Cocok untuk Acara?</h2>'
                    .'<ul><li>Disukai lintas usia</li><li>Praktis disajikan</li><li>Lebih hemat dibanding beli satuan</li><li>Bisa dipesan online tanpa ribet</li></ul>'
                    .'<h2>Pilih Paket Sesuai Kebutuhan</h2>'
                    .'<p>Tersedia paket dengan jumlah dan varian berbeda, sehingga Anda bisa menyesuaikan dengan jumlah tamu. Untuk acara besar, sebaiknya pesan lebih awal agar persiapan lebih matang.</p>'
                    .'<h2>Pesan Mudah lewat WhatsApp</h2>'
                    .'<p>Cukup pilih paket, konfirmasi jumlah, dan atur pengiriman lewat WhatsApp. Lihat pilihan <a href="/pempek-tince/paket-pempek">paket pempek Pempek Tince</a> untuk acara Anda berikutnya.</p>'
                    .$cta,
            ],
            [
                'slug' => 'rahasia-pempek-palembang-enak-kualitas-ikan',
                'title' => 'Rahasia Pempek Palembang Enak: Kualitas Ikan yang Utama',
                'category' => 'pempek',
                'keyword' => 'pempek ikan Palembang',
                'excerpt' => 'Apa yang membuat pempek Palembang begitu enak? Jawabannya ada pada kualitas ikan dan proses pembuatannya.',
                'meta_title' => 'Rahasia Pempek Palembang Enak: Kualitas Ikan Utama',
                'meta_description' => 'Rahasia pempek Palembang yang enak terletak pada kualitas ikan dan proses pembuatannya. Nikmati pempek ikan berkualitas di Pempek Tince.',
                'reading_time' => 5,
                'content' => '<p>Kenapa pempek Palembang terkenal enak? Banyak yang mengira rahasianya ada di cuko, padahal fondasinya justru pada <strong>ikan berkualitas</strong>. Mari kita bahas.</p>'
                    .'<h2>Ikan adalah Bintang Utama</h2>'
                    .'<p>Pempek yang enak menggunakan ikan giling dalam porsi yang cukup. Ikan gabus dan tenggiri sering dipilih karena menghasilkan rasa dan tekstur terbaik. Semakin baik kualitas ikan, semakin terasa gurihnya pempek.</p>'
                    .'<h2>Komposisi Sagu yang Tepat</h2>'
                    .'<p>Sagu memberi tekstur kenyal, tapi porsinya harus pas. Terlalu banyak sagu membuat pempek keras dan kehilangan rasa ikan.</p>'
                    .'<h2>Proses yang Higienis</h2>'
                    .'<p>Kebersihan dalam proses pembuatan menjaga kualitas dan keamanan pempek. Ini penting terutama untuk pempek yang akan dikirim jauh atau disimpan sebagai frozen.</p>'
                    .'<h2>Konsistensi Rasa</h2>'
                    .'<p>Pempek yang baik menjaga konsistensi rasa dari waktu ke waktu. Inilah yang membuat pelanggan kembali lagi. <a href="/pempek-tince">Pempek Tince</a> berkomitmen pada kualitas ikan dan rasa khas Palembang di setiap gigitan.</p>'
                    .$cta,
            ],
            [
                'slug' => 'cara-pesan-kirim-pempek-palembang-luar-kota',
                'title' => 'Cara Pesan & Kirim Pempek Palembang ke Luar Kota',
                'category' => 'pempek',
                'keyword' => 'pesan pempek Palembang',
                'excerpt' => 'Ingin pempek Palembang tapi berada di luar kota? Begini cara memesan dan mengirim pempek dengan mudah.',
                'meta_title' => 'Cara Pesan & Kirim Pempek Palembang ke Luar Kota',
                'meta_description' => 'Panduan memesan dan mengirim pempek Palembang ke luar kota lewat WhatsApp. Pesan pempek frozen tahan lama di Pempek Tince.',
                'reading_time' => 4,
                'content' => '<p>Tinggal di luar Palembang bukan berarti tidak bisa menikmati pempek asli. Kini <strong>pesan pempek Palembang</strong> dan kirim ke luar kota sangat mudah. Ini caranya.</p>'
                    .'<h2>1. Pilih Menu atau Paket</h2>'
                    .'<p>Tentukan varian atau <a href="/pempek-tince/paket-pempek">paket pempek</a> yang Anda inginkan. Untuk pengiriman jauh, opsi <a href="/pempek-tince/pempek-frozen">frozen</a> paling disarankan karena lebih tahan lama.</p>'
                    .'<h2>2. Konfirmasi via WhatsApp</h2>'
                    .'<p>Hubungi admin lewat WhatsApp untuk konfirmasi ketersediaan, jumlah, dan alamat pengiriman. Admin akan membantu menghitung ongkos kirim.</p>'
                    .'<h2>3. Pembayaran dan Proses</h2>'
                    .'<p>Setelah pembayaran, pesanan diproses dan dikemas dengan aman agar sampai dalam kondisi baik. Pempek frozen dikemas khusus untuk menjaga kualitas selama pengiriman.</p>'
                    .'<h2>Praktis dan Aman</h2>'
                    .'<p>Dengan proses yang simpel, Anda bisa menikmati pempek Palembang di mana pun berada. Mulai pesan sekarang lewat halaman <a href="/pempek-tince/pesan-online">Pesan Online Pempek Tince</a>.</p>'
                    .$cta,
            ],
        ];
    }
}
