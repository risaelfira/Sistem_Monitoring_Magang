<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeeklyProgressController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\ReportProgressController;
use App\Http\Controllers\SupportingDocumentController;
use App\Http\Controllers\DailyProgressController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION - GUEST
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // LOGIN
    Route::get('/login', [
        AuthController::class,
        'showLogin'
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login'
    ])->name('login.store');


    // REGISTER
    Route::get('/register', [
        AuthController::class,
        'showRegister'
    ])->name('register');

    Route::post('/register', [
        AuthController::class,
        'register'
    ])->name('register.store');

});


/*
|--------------------------------------------------------------------------
| HALAMAN SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('logout');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | PROGRES BAB 1 - 5
        |--------------------------------------------------------------------------
        */

        $chapters = \App\Models\ReportProgress::where(
            'user_id',
            $user->id
        )
        ->orderBy('chapter')
        ->get();    


        /*
        |--------------------------------------------------------------------------
        | RATA-RATA PROGRESS LAPORAN
        |--------------------------------------------------------------------------
        */

        $reportAvg = $chapters->count() > 0
            ? round($chapters->avg('progress_percentage'))
            : 0;


        /*
        |--------------------------------------------------------------------------
        | TOTAL KEGIATAN HARIAN
        |--------------------------------------------------------------------------
        */

        $dailyCount = \App\Models\DailyProgress::where(
            'user_id',
            $user->id
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL DOKUMEN SIDANG
        |--------------------------------------------------------------------------
        */

        $docsTotal = \App\Models\SupportingDocument::where(
            'user_id',
            $user->id
        )->count();


        /*
        |--------------------------------------------------------------------------
        | DOKUMEN SIDANG SELESAI
        |--------------------------------------------------------------------------
        */

        $docsDone = \App\Models\SupportingDocument::where(
            'user_id',
            $user->id
        )
        ->where('status', 'Done')
        ->count();


        /*
        |--------------------------------------------------------------------------
        | DOKUMENTASI TERBARU
        |--------------------------------------------------------------------------
        */

        $recentDocs = \App\Models\Documentation::where(
            'user_id',
            $user->id
        )
        ->latest()
        ->take(6)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | PROGRES HARIAN TERBARU
        |--------------------------------------------------------------------------
        */

        $recentDaily = \App\Models\DailyProgress::where(
            'user_id',
            $user->id
        )
        ->latest('date')
        ->take(6)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | OVERALL PROGRESS
        |--------------------------------------------------------------------------
        */

        $overall = round(
            (
                $reportAvg +
                ($docsTotal > 0
                    ? ($docsDone / $docsTotal) * 100
                    : 0
                )
            ) / 2
        );


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'overall',
            'reportAvg',
            'dailyCount',
            'chapters',
            'docsDone',
            'docsTotal',
            'recentDaily',
            'recentDocs'
        ));

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROGRES MINGGUAN
    |--------------------------------------------------------------------------
    */

    Route::get('/weekly-progress', [
        WeeklyProgressController::class,
        'index'
    ])->name('weekly-progress.index');

    Route::post('/weekly-progress', [
        WeeklyProgressController::class,
        'store'
    ])->name('weekly-progress.store');

    Route::get('/weekly-progress/{id}', [
        WeeklyProgressController::class,
        'show'
    ])->name('weekly-progress.show');

    Route::put('/weekly-progress/{id}', [
        WeeklyProgressController::class,
        'update'
    ])->name('weekly-progress.update');

    Route::delete('/weekly-progress/{id}', [
        WeeklyProgressController::class,
        'destroy'
    ])->name('weekly-progress.destroy');

    /*
    |--------------------------------------------------------------------------
    | DETAIL KEGIATAN & TUGAS HARIAN
    |--------------------------------------------------------------------------
    */

    Route::post('/weekly-progress/{id}/details', [
        WeeklyProgressController::class,
        'storeDetail'
    ])->name('weekly-progress.details.store');

    Route::delete('/weekly-progress/details/{detail}', [
        WeeklyProgressController::class,
        'destroyDetail'
    ])->name('weekly-progress.details.destroy');

    /*
    |--------------------------------------------------------------------------
    | DOKUMENTASI MAGANG
    |--------------------------------------------------------------------------
    */

    Route::get('/documentation', [
        DocumentationController::class,
        'index'
    ])->name('documentation.index');


    Route::post('/documentation', [
        DocumentationController::class,
        'store'
    ])->name('documentation.store');


    Route::delete('/documentation/{documentation}', [
        DocumentationController::class,
        'destroy'
    ])->name('documentation.destroy');

    // DOWNLOAD DOKUMENTASI
    Route::get('/documentation/{documentation}/download', [
        DocumentationController::class,
        'download'
    ])->name('documentation.download');

    /*
    |--------------------------------------------------------------------------
    | PROGRES LAPORAN AKHIR - BAB 1 SAMPAI BAB 5
    |--------------------------------------------------------------------------
    */

    Route::get('/report-progress', [
        ReportProgressController::class,
        'index'
    ])->name('report-progress.index');


    Route::post('/report-progress/{id}', [
        ReportProgressController::class,
        'update'
    ])->name('report-progress.update');


    /*
    |--------------------------------------------------------------------------
    | DOKUMEN PENUNJANG SIDANG MAGANG
    |--------------------------------------------------------------------------
    */

    Route::get('/supporting-documents', [
        SupportingDocumentController::class,
        'index'
    ])->name('supporting-documents.index');

    Route::get('/supporting-documents/create', [
        SupportingDocumentController::class,
        'create'
    ])->name('supporting-documents.create');

    Route::post('/supporting-documents', [
        SupportingDocumentController::class,
        'store'
    ])->name('supporting-documents.store');

    Route::get('/supporting-documents/{supportingDocument}/edit', [
        SupportingDocumentController::class,
        'edit'
    ])->name('supporting-documents.edit');

    Route::put('/supporting-documents/{supportingDocument}', [
        SupportingDocumentController::class,
        'update'
    ])->name('supporting-documents.update');

    Route::delete('/supporting-documents/{supportingDocument}', [
        SupportingDocumentController::class,
        'destroy'
    ])->name('supporting-documents.destroy');


    /*
    |--------------------------------------------------------------------------
    | PROGRES HARIAN TUGAS AKHIR
    |--------------------------------------------------------------------------
    */

    Route::resource('/daily-progress', DailyProgressController::class)
        ->except(['show'])
        ->names('daily-progress');

});