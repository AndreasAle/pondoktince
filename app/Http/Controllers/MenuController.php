<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MenuCategory;

class MenuController extends Controller
{
    public function index()
    {
        $page = $this->cmsPage('menu');

        $this->applySeo($page, [
            'title' => 'Menu Pondok Tince | Masakan Khas Palembang',
            'description' => 'Lihat menu Pondok Tince: aneka masakan khas Palembang untuk makan di tempat, take away, dan acara. Pesan langsung via WhatsApp.',
            'keywords' => 'menu Pondok Tince, makanan khas Palembang',
        ], $this->crumbs([['name' => 'Menu', 'url' => route('menu')]]));

        $categories = $this->categoriesFor(Brand::KEY_PONDOK);

        return view('pages.menu', [
            'page' => $page,
            'categories' => $categories,
            'brandKey' => Brand::KEY_PONDOK,
            'title' => 'Menu Pondok Tince',
            'subtitle' => 'Masakan khas Palembang untuk keluarga, tamu luar kota, dan acara.',
        ]);
    }

    public function pempek()
    {
        $page = $this->cmsPage('pempek-tince/menu');

        $this->applySeo($page, [
            'title' => 'Menu Pempek Tince | Varian Pempek Palembang',
            'description' => 'Varian pempek Palembang dari Pempek Tince: lenjer, kapal selam, adaan, dan lainnya. Bisa untuk makan di tempat, oleh-oleh, dan frozen.',
            'keywords' => 'menu Pempek Tince, varian pempek Palembang',
        ], $this->crumbs([
            ['name' => 'Pempek Tince', 'url' => route('pempek.index')],
            ['name' => 'Menu', 'url' => route('pempek.menu')],
        ]));

        $categories = $this->categoriesFor(Brand::KEY_PEMPEK);

        return view('pages.menu', [
            'page' => $page,
            'categories' => $categories,
            'brandKey' => Brand::KEY_PEMPEK,
            'title' => 'Menu Pempek Tince',
            'subtitle' => 'Pempek khas Palembang, siap untuk dine-in, oleh-oleh, dan frozen.',
        ]);
    }

    protected function categoriesFor(string $brandKey)
    {
        return MenuCategory::query()
            ->active()
            ->whereHas('brand', fn ($q) => $q->where('key', $brandKey))
            ->with(['activeItems' => fn ($q) => $q->ordered()])
            ->ordered()
            ->get()
            ->filter(fn ($cat) => $cat->activeItems->isNotEmpty())
            ->values();
    }
}
