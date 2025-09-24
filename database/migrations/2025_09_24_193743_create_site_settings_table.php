<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('tagline')->nullable();
            $table->json('short_description')->nullable();
            $table->json('vision')->nullable();
            $table->json('mission')->nullable();
            $table->json('about')->nullable();
            $table->json('address')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('hotline')->nullable();
            $table->string('office_hours')->nullable();
            $table->text('map_embed')->nullable();
            $table->string('feedback_url')->nullable();
            $table->string('feedback_email')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('dark_logo_path')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('presskit_url')->nullable();
            $table->string('sso_login_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
