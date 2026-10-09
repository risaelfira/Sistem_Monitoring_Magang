<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\WeeklyProgressDetail;

class WeeklyProgress extends Model
{
    use HasFactory;

    protected $table = 'weekly_progress';

    protected $fillable = [
        'user_id',
        'week_number',
        'start_date',
        'end_date',
        'activities',
        'insights',
        'tasks',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DETAIL HARIAN
    |--------------------------------------------------------------------------
    */

    public function details()
    {
        return $this->hasMany(
            WeeklyProgressDetail::class,
            'weekly_progress_id'
        );
    }
}