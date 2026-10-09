<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DailyProgress;
use App\Models\WeeklyProgress;
use App\Models\WeeklyProgressDetail;
use App\Models\Documentation;
use App\Models\ReportProgress;
use App\Models\SupportingDocument;
use App\Models\FinalProjectTask;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI PROGRES HARIAN
    |--------------------------------------------------------------------------
    */

    public function dailyProgress()
    {
        return $this->hasMany(DailyProgress::class);
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI PROGRES MINGGUAN
    |--------------------------------------------------------------------------
    */

    public function weeklyProgress()
    {
        return $this->hasMany( WeeklyProgress::class, 'user_id' );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI DOKUMENTASI
    |--------------------------------------------------------------------------
    */

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI PROGRES LAPORAN
    |--------------------------------------------------------------------------
    */

    public function reportProgress()
    {
        return $this->hasMany(ReportProgress::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DETAIL PROGRES MINGGUAN
    |--------------------------------------------------------------------------
    */

    public function weeklyProgressDetails()
    {
        return $this->hasMany( WeeklyProgressDetail::class, 'user_id' );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI DOKUMEN SIDANG
    |--------------------------------------------------------------------------
    */

    public function supportingDocuments()
    {
        return $this->hasMany(SupportingDocument::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PEMANTAUAN PROYEK AKHIR
    |--------------------------------------------------------------------------
    */

    public function finalProjectTasks()
    {
        return $this->hasMany(FinalProjectTask::class, 'user_id');
    }

}