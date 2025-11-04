<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE user_risk_assessments MODIFY total_skor INT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE user_risk_assessments MODIFY total_skor INT UNSIGNED NULL');
    }
};
