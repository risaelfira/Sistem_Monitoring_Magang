<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyProgress extends Model
{
    use HasFactory;

    protected $table = 'daily_progress';

    protected $fillable = [
        'user_id',
        'date',
        'short_description',
        'detailed_description',
        'screenshot_path',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}