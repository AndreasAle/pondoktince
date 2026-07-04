<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->foreignId('menu_category_id')->nullable()->constrained('menu_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->index();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->nullable();          // nullable = "harga menyesuaikan"
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->string('price_note')->nullable();             // e.g. "per porsi"
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->json('gallery')->nullable();

            $table->boolean('is_favorite')->default(false)->index();
            $table->boolean('is_best_seller')->default(false)->index();
            $table->boolean('is_spicy')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_available')->default(true)->index();

            $table->string('cta_label')->nullable();
            $table->string('wa_message_template', 1024)->nullable();

            // Optional SEO (for future detail pages)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['brand_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
