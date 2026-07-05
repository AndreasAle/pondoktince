<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MenuItem;
use App\Models\ProductPackage;
use App\Models\ProductReview;
use App\Services\SchemaService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function menuItem(string $slug, SchemaService $schema)
    {
        $product = MenuItem::query()->available()->where('slug', $slug)->with('brand')->firstOrFail();

        $related = MenuItem::query()->available()
            ->where('id', '!=', $product->id)
            ->when($product->menu_category_id, fn ($q) => $q->where('menu_category_id', $product->menu_category_id))
            ->with('brand')->ordered()->limit(4)->get();

        if ($related->count() < 4) {
            $related = MenuItem::query()->available()->where('id', '!=', $product->id)->with('brand')->ordered()->limit(4)->get();
        }

        return $this->render($product, 'menu', $product->brand?->key ?? Brand::KEY_PONDOK, $related, $schema);
    }

    public function package(string $slug, SchemaService $schema)
    {
        $product = ProductPackage::query()->active()->where('slug', $slug)->with('brand')->firstOrFail();

        $related = ProductPackage::query()->active()
            ->where('id', '!=', $product->id)
            ->ordered()->limit(4)->get();

        return $this->render($product, 'paket', Brand::KEY_PEMPEK, $related, $schema);
    }

    /**
     * Shared premium detail renderer for both product types.
     */
    protected function render($product, string $type, string $brandKey, $related, SchemaService $schema)
    {
        $reviews = $product->approvedReviews()->get();
        $ratingAvg = $product->ratingAvg();
        $ratingCount = $product->ratingCount();
        $breakdown = $product->ratingBreakdown();

        $desc = $product->short_description ?: strip_tags((string) $product->description);
        $image = $product->image_path ? asset('storage/'.$product->image_path) : null;

        seo()->title(trim($product->name.' | '.(settings()->site_name ?: 'Pondok Tince')))
            ->description($desc ?: ('Pesan '.$product->name.' khas Palembang via WhatsApp.'))
            ->image($product->image_path)
            ->breadcrumbs($this->crumbs([
                $type === 'paket'
                    ? ['name' => 'Pempek Tince', 'url' => route('pempek.index')]
                    : ['name' => 'Menu', 'url' => route('menu')],
                ['name' => $product->name, 'url' => url()->current()],
            ]));
        seo()->ogType = 'product';

        seo()->addSchema($schema->productWithReviews(
            $product->name,
            $desc,
            $image,
            $product->effectivePrice(),
            $ratingAvg,
            $ratingCount,
            $reviews,
            $type === 'paket' ? 'Pempek Palembang' : 'Kuliner Palembang'
        ));

        return view('pages.product-detail', [
            'product' => $product,
            'type' => $type,
            'brandKey' => $brandKey,
            'related' => $related,
            'reviews' => $reviews,
            'ratingAvg' => $ratingAvg,
            'ratingCount' => $ratingCount,
            'breakdown' => $breakdown,
        ]);
    }

    /**
     * Store a customer review (needs admin approval before showing).
     */
    public function review(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:menu,paket'],
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:80'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1500'],
            'website' => ['prohibited'], // honeypot
        ]);

        $model = $data['type'] === 'paket'
            ? ProductPackage::findOrFail($data['id'])
            : MenuItem::findOrFail($data['id']);

        $model->reviews()->create([
            'name' => $data['name'],
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'is_approved' => false,
            'visitor_hash' => hash('sha256', $request->ip().'|'.config('app.key')),
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda kami terima dan akan tampil setelah ditinjau.')
            ->withFragment('ulasan');
    }
}
