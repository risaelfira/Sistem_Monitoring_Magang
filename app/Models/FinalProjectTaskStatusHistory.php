<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalProjectTaskStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'final_project_task_status_histories';

    public $timestamps = false;

    protected $fillable = [
        'final_project_task_id',
        'user_id',
        'from_status',
        'to_status',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(
            FinalProjectTask::class,
            'final_project_task_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
