<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();          // full path relative slug, e.g. kuliner-palembang or pempek-tince/menu
            $table->string('brand_scope')->default('global')->index(); // global|pondok-tince|pempek-tince
            $table->string('page_type')->default('normal')->index();   // normal|seo_pillar|landing|legal|custom
            $table->string('view_key')->nullable();    // optional: bind to a dedicated blade template

            // Hero
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle', 1024)->nullable();
            $table->string('hero_image_path')->nullable();
            $table->string('hero_cta_label')->nullable();
            $table->string('hero_cta_url')->nullable();

            $table->longText('intro_content')->nullable(); // rich intro / SEO body

            // SEO
            $table->string('focus_keyword')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('breadcrumb_title')->nullable();
            $table->string('schema_type')->nullable();       // WebPage|Restaurant|Product|FAQPage...
            $table->json('custom_schema')->nullable();
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);

            // Sitemap
            $table->boolean('in_sitemap')->default(true);
            $table->decimal('sitemap_priority', 2, 1)->default(0.5);
            $table->string('sitemap_frequency')->default('weekly');

            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
