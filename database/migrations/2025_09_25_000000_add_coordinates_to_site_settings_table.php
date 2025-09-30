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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->decimal('map_lat', 10, 7)->nullable()->after('map_embed');
            $table->decimal('map_lng', 10, 7)->nullable()->after('map_lat');
            $table->unsignedTinyInteger('map_zoom')->nullable()->after('map_lng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['map_lat', 'map_lng', 'map_zoom']);
        });
    }
};
