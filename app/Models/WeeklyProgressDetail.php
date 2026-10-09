<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyProgressDetail extends Model
{
    use HasFactory;

    protected $table = 'weekly_progress_details';

    protected $fillable = [
        'weekly_progress_id',
        'user_id',
        'date',
        'activity',
        'task',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI MINGGU
    |--------------------------------------------------------------------------
    */

    public function weeklyProgress()
    {
        return $this->belongsTo(
            WeeklyProgress::class,
            'weekly_progress_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}