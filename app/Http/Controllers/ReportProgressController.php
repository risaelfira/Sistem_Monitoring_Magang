<?php

namespace App\Http\Controllers;

use App\Models\ReportProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportProgressController extends Controller
{
    /**
     * Menampilkan progres Bab 1 sampai Bab 5
     */
    public function index()
    {
        $chapters = ReportProgress::where('user_id', Auth::id())
            ->orderBy('chapter')
            ->get();

        return view('report.index', compact('chapters'));
    }


    /**
     * Mengubah status dan persentase progres bab
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'status' => [
                'required',
                'in:Belum Dikerjakan,On Progress,Revisi,Selesai'
            ],
        ]);


        $progress = ReportProgress::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        /*
        |--------------------------------------------------------------------------
        | STATUS → PERSENTASE PROGRESS
        |--------------------------------------------------------------------------
        |
        | Belum Dikerjakan = 0%
        | On Progress      = 50%
        | Revisi           = 75%
        | Selesai          = 100%
        |
        |--------------------------------------------------------------------------
        */

        switch ($request->status) {

            case 'Belum Dikerjakan':

                $progress->progress_percentage = 0;

                break;


            case 'On Progress':

                $progress->progress_percentage = 50;

                break;


            case 'Revisi':

                $progress->progress_percentage = 75;

                break;


            case 'Selesai':

                $progress->progress_percentage = 100;

                break;
        }


        // Simpan status
        $progress->status = $request->status;

        // Simpan perubahan
        $progress->save();

        // Update
        return redirect()
            ->route('report-progress.index')
            ->with(
                'success',
                'Status Bab ' . $progress->chapter . ' berhasil diperbarui menjadi ' .
                $progress->status . ' (' .
                $progress->progress_percentage .
                '%).'
            );
        // Gagal update
        return redirect()
            ->route('report-progress.index')
            ->with('error', 'Progres bab gagal diperbarui.');
    }
}