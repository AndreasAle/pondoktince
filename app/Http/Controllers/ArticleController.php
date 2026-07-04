<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        seo()->title('Artikel & Info Kuliner Palembang | '.(settings()->site_name ?: 'Pondok Tince'))
            ->description('Artikel seputar kuliner Palembang, pempek, dan info dari Pondok Tince & Pempek Tince.')
            ->breadcrumbs($this->crumbs([['name' => 'Artikel', 'url' => route('articles.index')]]));

        $categorySlug = $request->query('kategori');

        $articles = Article::query()->published()->latestFirst()->with('category')
            ->when($categorySlug, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $categorySlug)))
            ->paginate(9)->withQueryString();

        $categories = ArticleCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.articles-index', compact('articles', 'categories', 'categorySlug'));
    }

    public function show(string $slug)
    {
        $article = Article::query()->published()->where('slug', $slug)->with('category')->firstOrFail();

        seo()->forArticle($article)->breadcrumbs($this->crumbs([
            ['name' => 'Artikel', 'url' => route('articles.index')],
            ['name' => $article->title, 'url' => route('articles.show', $article->slug)],
        ]));

        seo()->addSchema([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => $article->excerpt,
            'image' => $article->featured_image_path ? asset('storage/'.$article->featured_image_path) : null,
            'datePublished' => optional($article->published_at)->toIso8601String(),
            'author' => ['@type' => 'Organization', 'name' => $article->author ?: (settings()->site_name ?: 'Pondok Tince')],
        ]);

        $related = Article::query()->published()->latestFirst()
            ->where('id', '!=', $article->id)
            ->when($article->article_category_id, fn ($q) => $q->where('article_category_id', $article->article_category_id))
            ->limit(3)->get();

        if ($related->count() < 3) {
            $related = Article::query()->published()->latestFirst()->where('id', '!=', $article->id)->limit(3)->get();
        }

        return view('pages.article-show', compact('article', 'related'));
    }
}
