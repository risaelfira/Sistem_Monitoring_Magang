<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    protected $table = 'documentations';

    protected $fillable = [
        'user_id',
        'description',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
