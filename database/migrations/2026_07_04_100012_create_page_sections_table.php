<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('type')->index(); // hero|text|image_text|menu_grid|product_grid|gallery|testimonial|faq|cta|location_map|brand_cards|article_list|package_cards|custom_html|seo_content
            $table->string('title')->nullable();
            $table->string('subtitle', 1024)->nullable();
            $table->longText('content')->nullable();
            $table->string('image_path')->nullable();
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->string('background_style')->default('default'); // default|muted|dark|brand
            $table->json('settings')->nullable();   // flexible per-type options (e.g. brand filter, item ids)
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
