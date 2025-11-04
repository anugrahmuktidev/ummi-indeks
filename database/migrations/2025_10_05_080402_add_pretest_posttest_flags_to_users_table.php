<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_completed_pretest')->default(false)->after('has_downloaded_leaflet');
            $table->boolean('has_completed_posttest')->default(false)->after('has_completed_pretest');
        });

        DB::statement(
            "UPDATE users SET has_completed_pretest = 1 WHERE EXISTS (" .
            "SELECT 1 FROM riwayat_skrining WHERE riwayat_skrining.user_id = users.id " .
            "AND riwayat_skrining.jenis_sesi = 'Pretest' AND riwayat_skrining.status = 'Completed')"
        );

        DB::statement(
            "UPDATE users SET has_completed_posttest = 1 WHERE EXISTS (" .
            "SELECT 1 FROM riwayat_skrining WHERE riwayat_skrining.user_id = users.id " .
            "AND riwayat_skrining.jenis_sesi = 'Post Test' AND riwayat_skrining.status = 'Completed')"
        );
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['has_completed_pretest', 'has_completed_posttest']);
        });
    }
};
