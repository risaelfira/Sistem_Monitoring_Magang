<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalProjectTask extends Model
{
    use HasFactory;

    protected $table = 'final_project_tasks';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(
            FinalProjectTaskStatusHistory::class,
            'final_project_task_id'
        )->latest('changed_at');
    }
}
