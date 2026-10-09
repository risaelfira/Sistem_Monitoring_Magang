<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportProgress extends Model
{
    protected $table = 'report_progress';

    protected $fillable = [
        'user_id',
        'chapter',
        'status',
        'progress_percentage',
    ];
}