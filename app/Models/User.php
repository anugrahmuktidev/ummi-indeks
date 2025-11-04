<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\UserMeasurement;
use App\Models\UserRiskAssessment;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'tanggal_lahir',
        'berat_badan',
        'tinggi_badan',
        'jenis_kelamin',
        'pendidikan',
        'pekerjaan',
        'pekerjaan_lain',
        'alamat',
        'rt',
        'no_rumah',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'role',
        'is_first_login',
        'profile_completed',
        'has_read_leaflet',
        'has_downloaded_leaflet',
        'has_completed_pretest',
        'has_completed_posttest',
        'has_submitted_measurement',
        'has_submitted_risk',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
        'profile_completed' => 'boolean',
        'has_read_leaflet' => 'boolean',
        'has_downloaded_leaflet' => 'boolean',
        'has_completed_pretest' => 'boolean',
        'has_completed_posttest' => 'boolean',
        'has_submitted_measurement' => 'boolean',
        'has_submitted_risk' => 'boolean',
    ];

    public function hasPassword(): bool
    {
        return ! empty($this->password);
    }

    public static function authenticateByNoHp($no_hp): ?self
    {
        return self::where('no_hp', $no_hp)->first();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        return true;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return null;
    }

    public function markProfileCompletedIfEligible(): void
    {
        if ($this->profile_completed) {
            return;
        }

        $required = [
            $this->name,
            $this->no_hp,
            $this->tanggal_lahir,
            $this->jenis_kelamin,
            $this->pendidikan,
            $this->pekerjaan ?? $this->pekerjaan_lain,
            $this->alamat,
            $this->kabupaten,
            $this->provinsi,
        ];

        if (collect($required)->contains(fn ($value) => blank($value))) {
            return;
        }

        $this->forceFill(['profile_completed' => true])->save();
    }

    public function latestMeasurement()
    {
        return $this->hasOne(UserMeasurement::class)->latestOfMany();
    }

    public function latestRiskAssessment()
    {
        return $this->hasOne(UserRiskAssessment::class)->latestOfMany();
    }

    public function riskAssessments()
    {
        return $this->hasMany(UserRiskAssessment::class);
    }
}
