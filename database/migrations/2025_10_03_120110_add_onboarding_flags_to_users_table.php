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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('profile_completed')->default(false)->after('is_first_login');
            $table->boolean('has_read_leaflet')->default(false)->after('profile_completed');
            $table->boolean('has_downloaded_leaflet')->default(false)->after('has_read_leaflet');
            $table->boolean('has_submitted_measurement')->default(false)->after('has_downloaded_leaflet');
            $table->boolean('has_submitted_risk')->default(false)->after('has_submitted_measurement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_completed',
                'has_read_leaflet',
                'has_downloaded_leaflet',
                'has_submitted_measurement',
                'has_submitted_risk',
            ]);
        });
    }
};
