<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->index();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('price_note')->nullable();
            $table->json('contents')->nullable();          // list of what's included
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();

            $table->boolean('is_frozen')->default(false)->index();
            $table->boolean('is_recommended')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();

            $table->string('cta_label')->nullable();
            $table->string('wa_message_template', 1024)->nullable();

            // SEO
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
        Schema::dropIfExists('product_packages');
    }
};
