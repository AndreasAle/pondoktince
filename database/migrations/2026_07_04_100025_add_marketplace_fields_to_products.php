<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->unsignedInteger('sold_count')->nullable()->after('is_available');
            $table->string('weight')->nullable()->after('sold_count'); // mis. "500 gr"
            $table->unsignedInteger('stock')->nullable()->after('weight');
        });

        Schema::table('product_packages', function (Blueprint $table) {
            $table->decimal('discount_price', 12, 2)->nullable()->after('price');
            $table->string('short_description')->nullable()->after('slug');
            $table->json('gallery')->nullable()->after('image_alt');
            $table->unsignedInteger('sold_count')->nullable()->after('is_active');
            $table->string('weight')->nullable()->after('sold_count');
            $table->unsignedInteger('stock')->nullable()->after('weight');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['sold_count', 'weight', 'stock']);
        });
        Schema::table('product_packages', function (Blueprint $table) {
            $table->dropColumn(['discount_price', 'short_description', 'gallery', 'sold_count', 'weight', 'stock']);
        });
    }
};
