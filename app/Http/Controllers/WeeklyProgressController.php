<?php

namespace App\Http\Controllers;

use App\Models\WeeklyProgress;
use App\Models\WeeklyProgressDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeeklyProgressController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $items = WeeklyProgress::where(
            'user_id',
            Auth::id()
        )
        ->with('details')
        ->orderBy('week_number', 'asc')
        ->get();

        return view('weekly.index', compact('items'));
    }


    /*
    |--------------------------------------------------------------------------
    | STORE MINGGU
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([
            'week_number' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'activities' => 'required|string',
            'insights' => 'required|string',
            'tasks' => 'required|string',
        ]);

        $data['user_id'] = Auth::id();

        WeeklyProgress::create($data);

        return redirect()
            ->route('weekly-progress.index')
            ->with(
                'success',
                'Progres minggu berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW DETAIL MINGGU
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $weeklyProgress = WeeklyProgress::where(
            'user_id',
            Auth::id()
        )
        ->with('details')
        ->findOrFail($id);

        return view(
            'weekly.show',
            compact('weeklyProgress')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE MINGGU
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $weeklyProgress = WeeklyProgress::where(
            'user_id',
            Auth::id()
        )->findOrFail($id);

        $data = $request->validate([
            'week_number' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'activities' => 'required|string',
            'insights' => 'required|string',
            'tasks' => 'required|string',
        ]);

        $weeklyProgress->update($data);

        return redirect()
            ->route(
                'weekly-progress.show',
                $weeklyProgress->id
            )
            ->with(
                'success',
                'Progres minggu berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE MINGGU
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $weeklyProgress = WeeklyProgress::where(
            'user_id',
            Auth::id()
        )->findOrFail($id);

        $weeklyProgress->delete();

        return redirect()
            ->route('weekly-progress.index')
            ->with(
                'success',
                'Progres minggu berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE DETAIL HARIAN
    |--------------------------------------------------------------------------
    */

    public function storeDetail(
        Request $request,
        $weeklyProgressId
    ) {
        $weeklyProgress = WeeklyProgress::where(
            'user_id',
            Auth::id()
        )->findOrFail($weeklyProgressId);

        $data = $request->validate([
            'date' => 'required|date',
            'activity' => 'required|string',
            'task' => 'nullable|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pastikan tanggal berada dalam periode minggu
        |--------------------------------------------------------------------------
        */

        $date = \Carbon\Carbon::parse($data['date']);

        if (
            $date->lt($weeklyProgress->start_date) ||
            $date->gt($weeklyProgress->end_date)
        ) {
            return back()
                ->withErrors([
                    'date' =>
                        'Tanggal harus berada dalam periode minggu tersebut.'
                ])
                ->withInput();
        }

        $data['weekly_progress_id'] = $weeklyProgress->id;
        $data['user_id'] = Auth::id();

        WeeklyProgressDetail::create($data);

        return redirect()
            ->route(
                'weekly-progress.show',
                $weeklyProgress->id
            )
            ->with(
                'success',
                'Detail kegiatan berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE DETAIL HARIAN
    |--------------------------------------------------------------------------
    */

    public function destroyDetail($id)
    {
        $detail = WeeklyProgressDetail::where(
            'user_id',
            Auth::id()
        )->findOrFail($id);

        $weeklyProgressId = $detail->weekly_progress_id;

        $detail->delete();

        return redirect()
            ->route(
                'weekly-progress.show',
                $weeklyProgressId
            )
            ->with(
                'success',
                'Detail kegiatan berhasil dihapus.'
            );
    }
}