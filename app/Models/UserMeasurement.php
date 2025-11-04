<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lingkar_lengan',
        'panjang_lengan',
        'ratio',
        'risk_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
