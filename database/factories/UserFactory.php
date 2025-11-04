<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'no_hp' => fake()->unique()->numerify('08#########'),
            'tanggal_lahir' => fake()->dateTimeBetween('-40 years', '-20 years'),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'pendidikan' => fake()->randomElement(['SD', 'SMP', 'SMA', 'PERGURUAN TINGGI']),
            'pekerjaan' => fake()->jobTitle(),
            'pekerjaan_lain' => null,
            'alamat' => fake()->address(),
            'rt' => fake()->numberBetween(1, 20),
            'no_rumah' => fake()->buildingNumber(),
            'kelurahan' => fake()->citySuffix(),
            'kecamatan' => fake()->citySuffix(),
            'kabupaten' => fake()->city(),
            'provinsi' => fake()->state(),
            'berat_badan' => fake()->numberBetween(45, 80),
            'tinggi_badan' => fake()->numberBetween(150, 180),
            'profile_completed' => true,
            'has_read_leaflet' => true,
            'has_downloaded_leaflet' => true,
            'has_submitted_measurement' => true,
            'has_submitted_risk' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
