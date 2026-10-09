<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\WeeklyProgress;
use App\Models\Documentation;
use App\Models\ReportProgress;
use App\Models\SupportingDocument;
use App\Models\DailyProgress;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | PROGRES LAPORAN BAB 1 - 5
        |--------------------------------------------------------------------------
        */

        $reports = ReportProgress::where(
            'user_id',
            $user->id
        )
        ->orderBy('chapter')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | Jika data Bab belum ada, tampilkan Bab 1 - 5
        |--------------------------------------------------------------------------
        */

        $chapters = $reports->count()
            ? $reports
            : collect(range(1, 5))->map(function ($n) {
                return (object) [
                    'chapter' => $n,
                    'status' => 'Belum Dikerjakan',
                    'progress_percentage' => 0,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA PROGRESS LAPORAN
        |--------------------------------------------------------------------------
        */

        $reportAvg = round(
            $chapters->avg('progress_percentage') ?? 0
        );

        /*
        |--------------------------------------------------------------------------
        | DOKUMEN SIDANG
        |--------------------------------------------------------------------------
        */

        $docsTotal = SupportingDocument::where(
            'user_id',
            $user->id
        )->count();

        $docsDone = SupportingDocument::where(
            'user_id',
            $user->id
        )
        ->where('status', 'Done')
        ->count();

        /*
        |--------------------------------------------------------------------------
        | PROGRES HARIAN
        |--------------------------------------------------------------------------
        */

        $dailyCount = DailyProgress::where(
            'user_id',
            $user->id
        )->count();

        /*
        |--------------------------------------------------------------------------
        | PROGRES MINGGUAN
        |--------------------------------------------------------------------------
        */

        $weeklyCount = WeeklyProgress::where(
            'user_id',
            $user->id
        )->count();

        /*
        |--------------------------------------------------------------------------
        | OVERALL PROGRESS
        |--------------------------------------------------------------------------
        */

        $overall = round(
            (
                $reportAvg
                + min($weeklyCount * 5, 100)
                + min($dailyCount * 3, 100)
            ) / 3
        );

        /*
        |--------------------------------------------------------------------------
        | DATA TERBARU PROGRES MINGGUAN
        |--------------------------------------------------------------------------
        */

        $recentWeekly = WeeklyProgress::where(
            'user_id',
            $user->id
        )
        ->latest()
        ->take(3)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA TERBARU PROGRES HARIAN
        |--------------------------------------------------------------------------
        */

        $recentDaily = DailyProgress::where(
            'user_id',
            $user->id
        )
        ->latest('date')
        ->take(5)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | DOKUMENTASI TERBARU
        |--------------------------------------------------------------------------
        */

        $recentDocs = Documentation::where(
            'user_id',
            $user->id
        )
        ->latest()
        ->take(6)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(
                'chapters',
                'reportAvg',
                'docsDone',
                'docsTotal',
                'dailyCount',
                'overall',
                'recentWeekly',
                'recentDaily',
                'recentDocs'
            )
        );
    }
}