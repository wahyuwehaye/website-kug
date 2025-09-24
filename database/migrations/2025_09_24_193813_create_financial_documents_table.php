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
        Schema::create('financial_documents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title');
            $table->json('description')->nullable();
            $table->string('document_number')->nullable();
            $table->string('category')->default('report');
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->year('year')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('effective_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_documents');
    }
};
