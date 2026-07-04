<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_click_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source_page')->nullable()->index();
            $table->string('button_label')->nullable();
            $table->string('brand_key')->nullable()->index();
            $table->string('destination_number')->nullable();
            $table->text('message_preview')->nullable();
            $table->string('visitor_hash', 64)->nullable()->index(); // anonymised (hashed IP+UA)
            $table->string('user_agent', 512)->nullable();
            $table->string('referrer', 1024)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_click_logs');
    }
};
