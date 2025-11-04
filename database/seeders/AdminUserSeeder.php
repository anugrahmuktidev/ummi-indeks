<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'no_hp' => '0800000000',
                'role' => 'admin',
                'is_first_login' => false,
                'profile_completed' => true,
                'has_read_leaflet' => true,
                'has_downloaded_leaflet' => true,
                'has_submitted_measurement' => true,
                'has_submitted_risk' => true,
            ]
        );
    }
}
