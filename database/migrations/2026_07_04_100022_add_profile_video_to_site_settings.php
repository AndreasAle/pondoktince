<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('profile_video_enabled')->default(true);
            $table->string('profile_video_path')->nullable();    // file mp4 hasil upload
            $table->string('profile_video_url')->nullable();     // YouTube / Vimeo / URL mp4
            $table->string('profile_video_poster')->nullable();  // gambar poster
            $table->boolean('profile_video_autoplay')->default(false); // mode background muted-loop (khusus mp4)
            $table->string('profile_video_eyebrow')->nullable();
            $table->string('profile_video_title')->nullable();
            $table->text('profile_video_subtitle')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'profile_video_enabled', 'profile_video_path', 'profile_video_url',
                'profile_video_poster', 'profile_video_autoplay',
                'profile_video_eyebrow', 'profile_video_title', 'profile_video_subtitle',
            ]);
        });
    }
};
