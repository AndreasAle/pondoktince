<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gallery;
use App\Models\HeroSlide;
use App\Models\MenuItem;
use App\Models\Testimonial;
use App\Services\SchemaService;

class HomeController extends Controller
{
    public function index(SchemaService $schema)
    {
        $page = $this->cmsPage('home');

        $this->applySeo($page, [
            'title' => (settings()->site_name ?: 'Pondok Tince').' | Kuliner Khas Palembang',
            'description' => 'Pondok Tince, tempat makan khas Palembang untuk keluarga, tamu luar kota, dan acara. Terhubung dengan Pempek Tince untuk oleh-oleh dan pesanan pempek.',
            'keywords' => 'kuliner Palembang, makanan enak Palembang, pempek Palembang',
        ]);
        seo()->canonical(url('/'))->addSchema($schema->restaurant());

        $brands = Brand::active()->ordered()->get()->keyBy('key');

        $favorites = MenuItem::query()
            ->available()
            ->where('is_favorite', true)
            ->with('brand')
            ->ordered()
            ->limit(6)
            ->get();

        if ($favorites->isEmpty()) {
            $favorites = MenuItem::query()->available()->with('brand')->ordered()->limit(6)->get();
        }

        $gallery = Gallery::active()->ordered()->limit(8)->get();
        $testimonials = Testimonial::active()->ordered()->limit(6)->get();
        $heroSlides = HeroSlide::active()->ordered()->get();

        return view('pages.home', compact('page', 'brands', 'favorites', 'gallery', 'testimonials', 'heroSlides'));
    }
}
