<?php

namespace App\Support;

/**
 * Konten kaya (long-form) untuk 3 halaman SEO pillar.
 * Dipisah dari controller/view agar mudah dirawat & dioptimasi untuk SEO.
 * Tidak memakai route()/url() di sini supaya aman terhadap config/route cache.
 */
class PillarContent
{
    public static function for(string $slug): ?array
    {
        return static::all()[$slug] ?? null;
    }

    public static function all(): array
    {
        return [
            /* =========================================================
             |  KULINER PALEMBANG  (brand: Pondok Tince)
             ========================================================= */
            'kuliner-palembang' => [
                'brand' => 'pondok-tince',
                'eyebrow' => 'Kuliner Palembang',
                'title' => 'Kuliner Palembang di Pondok Tince',
                'subtitle' => 'Nikmati kuliner khas Palembang yang hangat untuk keluarga, tamu luar kota, dan acara — semua dalam satu tempat yang nyaman.',
                'keyword' => 'kuliner Palembang, kuliner khas Palembang',
                'meta_title' => 'Kuliner Palembang di Pondok Tince — Tempat Makan Khas & Nyaman',
                'meta_description' => 'Cari kuliner Palembang yang enak dan nyaman? Pondok Tince menyajikan masakan khas Palembang untuk keluarga, rombongan, dan acara. Lihat menu, lokasi, & booking.',
                'intro' => 'Palembang bukan hanya kota pempek. Di balik itu ada kekayaan <strong>kuliner Palembang</strong> yang menggugah selera — dari sajian berkuah gurih hingga lauk bercita rasa kuat khas Sumatera Selatan. Di <strong>Pondok Tince</strong>, kami menghadirkan kuliner khas Palembang dalam suasana yang hangat dan bersahabat, cocok untuk makan bersama keluarga, menjamu tamu luar kota, maupun menggelar acara.',
                'highlights' => [
                    ['icon' => 'utensils', 'text' => 'Masakan Khas Palembang'],
                    ['icon' => 'users', 'text' => 'Nyaman untuk Keluarga'],
                    ['icon' => 'route', 'text' => 'Ramah Tamu Luar Kota'],
                    ['icon' => 'calendar', 'text' => 'Booking & Acara Mudah'],
                ],
                'sections' => [
                    ['h2' => 'Tempat Makan Khas Palembang untuk Keluarga', 'body' => '<p>Mencari tempat makan yang cocok untuk seluruh anggota keluarga memang tidak mudah. Pondok Tince hadir sebagai <strong>tempat makan khas Palembang</strong> dengan suasana nyaman, porsi bersahabat, dan menu yang beragam. Anak-anak, orang tua, hingga tamu istimewa bisa menemukan pilihan favoritnya di sini.</p><p>Kami percaya makan bukan sekadar mengisi perut, tapi momen berkumpul. Karena itu, kenyamanan tempat dan kehangatan pelayanan menjadi prioritas kami.</p>'],
                    ['h2' => 'Ragam Menu Kuliner Palembang yang Bisa Dicoba', 'body' => '<p>Dari <em>pindang</em> yang segar berbumbu, tekwan dan model berkuah kaldu, hingga aneka lauk khas — menu kami dirancang untuk dinikmati bersama. Setiap hidangan diolah dengan bumbu yang seimbang agar cita rasa khas Palembang tetap terjaga.</p><p>Ingin tahu selengkapnya? Lihat daftar menu Pondok Tince dan temukan hidangan yang paling menggugah selera Anda.</p>'],
                    ['h2' => 'Cocok untuk Tamu Luar Kota dan Rombongan', 'body' => '<p>Sedang menjamu kerabat dari luar kota atau membawa rombongan? Pondok Tince siap menyambut Anda. Suasananya pas untuk memperkenalkan cita rasa asli Palembang kepada tamu, dan kapasitasnya fleksibel untuk grup besar.</p><p>Untuk kebutuhan acara — arisan, meeting kantor, hingga syukuran keluarga — Anda bisa berkonsultasi lebih dulu lewat WhatsApp agar persiapan lebih matang.</p>'],
                    ['h2' => 'Lokasi Strategis di Palembang', 'body' => '<p>Pondok Tince berlokasi di Palembang dan mudah dijangkau. Anda bisa membuka Google Maps untuk melihat rute, atau menghubungi kami langsung untuk menanyakan patokan lokasi dan jam buka.</p>'],
                    ['h2' => 'Terhubung dengan Pempek Tince untuk Oleh-Oleh', 'body' => '<p>Belum lengkap ke Palembang tanpa membawa pulang pempek. Lewat sub-brand <strong>Pempek Tince</strong>, Anda bisa memesan pempek Palembang untuk oleh-oleh, stok frozen, hingga pengiriman ke luar kota. Satu ekosistem, dua pengalaman.</p>'],
                ],
                'features' => [
                    ['icon' => 'heart', 'title' => 'Cita Rasa Autentik', 'desc' => 'Bumbu khas Palembang yang dijaga konsistensinya di setiap sajian.'],
                    ['icon' => 'users', 'title' => 'Ramah Keluarga', 'desc' => 'Suasana hangat dan porsi yang pas untuk dinikmati bersama.'],
                    ['icon' => 'calendar', 'title' => 'Siap untuk Acara', 'desc' => 'Cocok untuk arisan, meeting, dan rombongan tamu luar kota.'],
                    ['icon' => 'chat', 'title' => 'Pesan Mudah', 'desc' => 'Reservasi dan tanya menu cukup lewat WhatsApp, cepat dibalas.'],
                ],
                'faqs' => [
                    ['q' => 'Apa saja menu kuliner khas Palembang di Pondok Tince?', 'a' => 'Tersedia beragam sajian khas Palembang seperti menu berkuah dan aneka lauk. Silakan lihat halaman Menu untuk daftar lengkap dan terbaru.'],
                    ['q' => 'Apakah cocok untuk makan keluarga besar?', 'a' => 'Sangat cocok. Pondok Tince nyaman untuk keluarga maupun rombongan. Untuk grup besar, disarankan booking terlebih dahulu.'],
                    ['q' => 'Bisakah untuk acara atau rombongan tamu luar kota?', 'a' => 'Bisa. Anda dapat berkonsultasi via WhatsApp untuk kebutuhan acara, jumlah tamu, dan menu yang diinginkan.'],
                    ['q' => 'Di mana lokasi Pondok Tince?', 'a' => 'Kami berada di Palembang dan mudah dijangkau. Lihat halaman Lokasi untuk peta dan jam buka.'],
                    ['q' => 'Apakah menyediakan oleh-oleh khas Palembang?', 'a' => 'Ya, melalui Pempek Tince Anda bisa memesan pempek untuk oleh-oleh, frozen, dan pengiriman luar kota.'],
                ],
                'links' => [
                    ['label' => 'Lihat Menu', 'path' => '/menu'],
                    ['label' => 'Makanan Enak Palembang', 'path' => '/makanan-enak-palembang'],
                    ['label' => 'Pempek Palembang', 'path' => '/pempek-palembang'],
                    ['label' => 'Paket Acara', 'path' => '/paket-acara'],
                    ['label' => 'Lokasi & Jam Buka', 'path' => '/lokasi'],
                    ['label' => 'Pempek Tince', 'path' => '/pempek-tince'],
                ],
            ],

            /* =========================================================
             |  PEMPEK PALEMBANG  (brand: Pempek Tince)
             ========================================================= */
            'pempek-palembang' => [
                'brand' => 'pempek-tince',
                'eyebrow' => 'Pempek Palembang',
                'title' => 'Pempek Palembang di Pempek Tince',
                'subtitle' => 'Pempek khas Palembang untuk makan di tempat, oleh-oleh, dan frozen — dibuat dengan ikan berkualitas dan cita rasa autentik.',
                'keyword' => 'pempek Palembang, pempek Palembang enak',
                'meta_title' => 'Pempek Palembang di Pempek Tince — Enak, Oleh-Oleh & Frozen',
                'meta_description' => 'Pempek Palembang asli dari Pempek Tince: ikan berkualitas, cuko khas, cocok untuk oleh-oleh & frozen. Bisa pesan online dan kirim luar kota. Pesan via WhatsApp.',
                'intro' => '<strong>Pempek Palembang</strong> adalah ikon kuliner Sumatera Selatan yang melegenda — perpaduan ikan dan sagu yang kenyal, disiram cuko yang asam-pedas-manis. Di <strong>Pempek Tince</strong>, setiap pempek dibuat dengan ikan berkualitas dan resep yang menjaga rasa khas Palembang, siap dinikmati di tempat, dibawa pulang sebagai oleh-oleh, maupun disimpan sebagai stok frozen.',
                'highlights' => [
                    ['icon' => 'fish', 'text' => 'Ikan Berkualitas'],
                    ['icon' => 'gift', 'text' => 'Cocok untuk Oleh-Oleh'],
                    ['icon' => 'snowflake', 'text' => 'Tersedia Frozen'],
                    ['icon' => 'truck', 'text' => 'Kirim Luar Kota'],
                ],
                'sections' => [
                    ['h2' => 'Pempek Khas Palembang untuk Makan di Tempat dan Oleh-Oleh', 'body' => '<p>Nikmati pempek Palembang selagi hangat, atau bawa pulang untuk keluarga di rumah. Pempek Tince cocok untuk keduanya — teksturnya kenyal, isinya padat, dan cukonya dibuat dengan takaran yang pas.</p><p>Sebagai oleh-oleh khas Palembang, pempek kami dikemas rapi agar praktis dibawa bepergian.</p>'],
                    ['h2' => 'Varian Pempek yang Bisa Dipesan', 'body' => '<p>Dari kapal selam berisi telur, lenjer yang klasik, hingga adaan yang gurih — tersedia beragam varian untuk selera yang berbeda. Lihat menu Pempek Tince untuk daftar lengkap varian yang tersedia.</p>'],
                    ['h2' => 'Paket Pempek untuk Keluarga dan Rombongan', 'body' => '<p>Butuh dalam jumlah banyak untuk keluarga, kantor, atau acara? Tersedia paket pempek yang lebih hemat dan praktis. Anda tinggal pilih paket, lalu konfirmasi lewat WhatsApp.</p>'],
                    ['h2' => 'Pempek Frozen dan Pesanan Online', 'body' => '<p>Ingin stok pempek di rumah atau mengirim ke keluarga di luar kota? Pempek frozen Pempek Tince tahan lebih lama dan praktis — cukup digoreng sendiri saat ingin menyantapnya. Pemesanan bisa dilakukan online via WhatsApp.</p>'],
                    ['h2' => 'Cara Pesan Pempek Tince', 'body' => '<p>Prosesnya mudah: pilih menu atau paket, klik WhatsApp, konfirmasi stok dan pengiriman, lakukan pembayaran, lalu pesanan diproses. Simpel dan cepat.</p>'],
                ],
                'features' => [
                    ['icon' => 'fish', 'title' => 'Ikan Berkualitas', 'desc' => 'Bahan pilihan untuk tekstur kenyal dan rasa yang mantap.'],
                    ['icon' => 'fire', 'title' => 'Cuko Khas', 'desc' => 'Cuko asam-pedas-manis yang menjadi jiwa pempek Palembang.'],
                    ['icon' => 'snowflake', 'title' => 'Opsi Frozen', 'desc' => 'Tahan lebih lama, praktis untuk stok dan pengiriman.'],
                    ['icon' => 'truck', 'title' => 'Kirim Luar Kota', 'desc' => 'Bisa dikirim untuk keluarga dan kerabat di kota lain.'],
                ],
                'faqs' => [
                    ['q' => 'Apakah pempek bisa dikirim ke luar kota?', 'a' => 'Bisa, terutama untuk pempek frozen yang lebih tahan lama. Silakan konfirmasi pengiriman via WhatsApp.'],
                    ['q' => 'Apakah tersedia pempek frozen?', 'a' => 'Tersedia. Pempek frozen praktis untuk stok di rumah maupun pengiriman ke luar kota.'],
                    ['q' => 'Berapa lama pempek bisa bertahan?', 'a' => 'Pempek frozen dapat bertahan lebih lama bila disimpan di freezer. Detail penyimpanan bisa ditanyakan ke admin.'],
                    ['q' => 'Bisakah memesan dalam jumlah banyak?', 'a' => 'Bisa. Untuk pesanan banyak atau paket, sebaiknya hubungi kami lebih awal via WhatsApp.'],
                    ['q' => 'Apa saja varian pempek yang tersedia?', 'a' => 'Tersedia berbagai varian seperti kapal selam, lenjer, adaan, dan lainnya. Lihat menu Pempek Tince untuk daftar terbaru.'],
                ],
                'links' => [
                    ['label' => 'Pempek Tince', 'path' => '/pempek-tince'],
                    ['label' => 'Menu Pempek', 'path' => '/pempek-tince/menu'],
                    ['label' => 'Paket Pempek', 'path' => '/pempek-tince/paket-pempek'],
                    ['label' => 'Oleh-Oleh Palembang', 'path' => '/pempek-tince/oleh-oleh-palembang'],
                    ['label' => 'Pempek Frozen', 'path' => '/pempek-tince/pempek-frozen'],
                    ['label' => 'Kuliner Palembang', 'path' => '/kuliner-palembang'],
                ],
            ],

            /* =========================================================
             |  MAKANAN ENAK PALEMBANG  (brand: Pondok Tince)
             ========================================================= */
            'makanan-enak-palembang' => [
                'brand' => 'pondok-tince',
                'eyebrow' => 'Makanan Enak Palembang',
                'title' => 'Makanan Enak di Palembang untuk Keluarga & Rombongan',
                'subtitle' => 'Bingung mau makan di mana? Temukan makanan enak khas Palembang di Pondok Tince — nyaman untuk keluarga, rombongan, dan tamu luar kota.',
                'keyword' => 'makanan enak Palembang, makanan khas Palembang',
                'meta_title' => 'Makanan Enak di Palembang untuk Keluarga & Rombongan — Pondok Tince',
                'meta_description' => 'Rekomendasi makanan enak di Palembang khas dan nyaman untuk keluarga & rombongan. Pondok Tince siap menyambut Anda. Lihat menu, booking, dan lokasi.',
                'intro' => 'Sedang mencari <strong>makanan enak di Palembang</strong> tapi bingung harus ke mana? Pondok Tince bisa jadi jawabannya. Kami menyajikan <strong>makanan khas Palembang</strong> dengan cita rasa autentik dalam suasana yang nyaman — pas untuk makan sehari-hari bersama keluarga maupun momen spesial bersama rombongan dan tamu istimewa.',
                'highlights' => [
                    ['icon' => 'star', 'text' => 'Rasa Autentik Palembang'],
                    ['icon' => 'users', 'text' => 'Cocok untuk Keluarga'],
                    ['icon' => 'sofa', 'text' => 'Nyaman untuk Rombongan'],
                    ['icon' => 'calendar', 'text' => 'Bisa Booking'],
                ],
                'sections' => [
                    ['h2' => 'Rekomendasi Makanan Enak Khas Palembang', 'body' => '<p>Palembang punya banyak sajian yang wajib dicoba. Di Pondok Tince, Anda bisa menikmati beragam makanan khas Palembang dalam satu tempat — mulai dari hidangan berkuah hingga lauk bercita rasa kuat. Setiap menu dibuat agar terasa enak dan mengenyangkan.</p>'],
                    ['h2' => 'Kenapa Pondok Tince Cocok untuk Makan Keluarga', 'body' => '<p>Suasana yang hangat, pelayanan ramah, dan porsi yang pas membuat Pondok Tince menjadi pilihan tepat untuk makan bersama keluarga. Tempat yang nyaman membuat waktu berkumpul terasa lebih berkesan.</p>'],
                    ['h2' => 'Menu Favorit yang Bisa Dicoba', 'body' => '<p>Bingung pilih apa? Mulai dari menu favorit pelanggan yang paling sering dipesan. Lihat halaman Menu untuk melihat pilihan lengkap beserta detailnya.</p>'],
                    ['h2' => 'Cocok untuk Tamu Luar Kota', 'body' => '<p>Ingin menjamu tamu dari luar kota dengan cita rasa asli Palembang? Ajak mereka mampir ke Pondok Tince. Ini cara yang pas untuk memperkenalkan makanan khas Palembang yang otentik.</p>'],
                    ['h2' => 'Booking Tempat dan Lihat Lokasi', 'body' => '<p>Agar tidak kehabisan tempat — terutama untuk grup besar — Anda bisa melakukan booking terlebih dahulu. Jangan lupa cek halaman Lokasi untuk peta dan jam buka.</p>'],
                ],
                'features' => [
                    ['icon' => 'star', 'title' => 'Enak & Autentik', 'desc' => 'Makanan khas Palembang dengan rasa yang dijaga konsisten.'],
                    ['icon' => 'users', 'title' => 'Ramah Keluarga', 'desc' => 'Suasana nyaman untuk makan bersama orang tersayang.'],
                    ['icon' => 'sofa', 'title' => 'Muat Rombongan', 'desc' => 'Kapasitas fleksibel untuk grup dan acara.'],
                    ['icon' => 'pin', 'title' => 'Lokasi Mudah', 'desc' => 'Berada di Palembang dan gampang dijangkau.'],
                ],
                'faqs' => [
                    ['q' => 'Di mana tempat makan enak di Palembang untuk keluarga?', 'a' => 'Pondok Tince adalah salah satu pilihan tempat makan khas Palembang yang nyaman untuk keluarga. Lihat menu dan lokasi kami.'],
                    ['q' => 'Apakah cocok untuk rombongan?', 'a' => 'Cocok. Kapasitasnya fleksibel untuk rombongan. Untuk grup besar disarankan booking lebih dulu.'],
                    ['q' => 'Apa menu yang direkomendasikan?', 'a' => 'Mulai dari menu favorit pelanggan yang paling sering dipesan. Detailnya ada di halaman Menu.'],
                    ['q' => 'Apakah bisa untuk menjamu tamu luar kota?', 'a' => 'Sangat bisa. Pondok Tince pas untuk memperkenalkan cita rasa asli Palembang kepada tamu dari luar kota.'],
                    ['q' => 'Bagaimana cara reservasi?', 'a' => 'Anda bisa mengisi form booking di website atau menghubungi kami langsung via WhatsApp.'],
                ],
                'links' => [
                    ['label' => 'Lihat Menu', 'path' => '/menu'],
                    ['label' => 'Booking Tempat', 'path' => '/booking'],
                    ['label' => 'Lokasi & Jam Buka', 'path' => '/lokasi'],
                    ['label' => 'Kuliner Palembang', 'path' => '/kuliner-palembang'],
                    ['label' => 'Pempek Palembang', 'path' => '/pempek-palembang'],
                    ['label' => 'Paket Acara', 'path' => '/paket-acara'],
                ],
            ],
        ];
    }
}
