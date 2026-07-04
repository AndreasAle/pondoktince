<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Singleton-style settings table. A single row (id = 1) holds all global
 * site configuration that is editable from the Filament "Site Settings" page.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('site_name')->default('Pondok Tince');
            $table->string('tagline')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('default_og_image_path')->nullable();

            // Theme
            $table->string('primary_color')->default('#7a1f1f');
            $table->string('accent_color')->default('#c79a3a');

            // Contact / business info
            $table->string('address')->nullable();
            $table->string('maps_embed', 2048)->nullable();
            $table->string('maps_link', 1024)->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp_number')->nullable();          // primary WA (Pondok Tince)
            $table->string('whatsapp_number_pempek')->nullable();   // Pempek Tince WA
            $table->json('opening_hours')->nullable();              // [{day, open, close, closed}]

            // Social
            $table->string('instagram_pondok')->nullable();
            $table->string('instagram_pempek')->nullable();

            // SEO defaults
            $table->string('default_seo_title')->nullable();
            $table->text('default_seo_description')->nullable();
            $table->string('google_site_verification')->nullable();
            $table->text('head_scripts')->nullable();               // analytics etc.

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
