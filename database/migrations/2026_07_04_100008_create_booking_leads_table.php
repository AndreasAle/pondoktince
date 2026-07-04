<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('whatsapp_number');
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->unsignedInteger('people_count')->nullable();
            $table->string('purpose')->nullable();     // makan keluarga, meeting, arisan, ...
            $table->string('brand_key')->nullable();   // pondok-tince | pempek-tince
            $table->text('notes')->nullable();
            $table->string('source_page')->nullable();
            $table->string('status')->default('new')->index(); // new|contacted|confirmed|cancelled|done
            $table->text('internal_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_leads');
    }
};
