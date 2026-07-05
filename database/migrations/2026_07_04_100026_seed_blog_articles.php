<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Support\BlogArticles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

/**
 * Menanam artikel SEO (fokus pempek Palembang). Idempoten: hanya membuat
 * artikel yang slug-nya belum ada, sehingga aman dijalankan berulang & saat deploy.
 */
return new class extends Migration
{
    public function up(): void
    {
        $category = ArticleCategory::firstOrCreate(
            ['slug' => 'pempek'],
            ['name' => 'Pempek', 'is_active' => true, 'sort_order' => 2]
        );

        $i = 0;
        foreach (BlogArticles::all() as $article) {
            if (Article::where('slug', $article['slug'])->exists()) {
                continue;
            }

            Article::create([
                'title' => $article['title'],
                'slug' => $article['slug'],
                'article_category_id' => $category->id,
                'brand_scope' => 'pempek-tince',
                'excerpt' => $article['excerpt'],
                'content' => $article['content'],
                'focus_keyword' => $article['keyword'],
                'meta_title' => $article['meta_title'],
                'meta_description' => $article['meta_description'],
                'author' => 'Tim Pempek Tince',
                'reading_time' => $article['reading_time'] ?? 5,
                'is_published' => true,
                'published_at' => now()->subDays($i++),
            ]);
        }
    }

    public function down(): void
    {
        foreach (BlogArticles::all() as $article) {
            Article::where('slug', $article['slug'])->forceDelete();
        }
    }
};
