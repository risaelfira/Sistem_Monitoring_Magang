<?php

namespace App\Http\Controllers;

use App\Models\DailyProgress;
use App\Models\WeeklyProgress;
use App\Support\ImageDuplicateChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DailyProgressController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $selectedWeek = $request->query('week');

        if ($selectedWeek !== null && (!ctype_digit((string) $selectedWeek) || (int) $selectedWeek < 1 || (int) $selectedWeek > 20)) {
            abort(404);
        }

        $weeklyPeriods = WeeklyProgress::where('user_id', Auth::id())
            ->whereBetween('week_number', [1, 20])
            ->orderBy('week_number')
            ->get()
            ->keyBy('week_number');

        $weekRanges = [];
        foreach ($weeklyPeriods as $weekNumber => $period) {
            $weekRanges[$weekNumber] = $period->start_date->toDateString() . ' - ' . $period->end_date->toDateString();
        }

        $query = DailyProgress::where('user_id', Auth::id());

        if ($selectedWeek !== null) {
            $period = $weeklyPeriods->get((int) $selectedWeek);

            // Setiap filter minggu menggunakan tanggal mulai dan akhir pada Progres Mingguan.
            // Jika periode minggu belum dibuat, hasilnya dikosongkan agar data tidak salah dikelompokkan.
            if ($period) {
                $query->whereDate('date', '>=', $period->start_date->toDateString())
                    ->whereDate('date', '<=', $period->end_date->toDateString());
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $items = $query->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('daily.index', compact('items', 'selectedWeek', 'weeklyPeriods', 'weekRanges'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('daily.form', [
            'item' => new DailyProgress()
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'short_description' => 'required|string|max:255',
            'detailed_description' => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Screenshot
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('screenshot')) {

            if (ImageDuplicateChecker::exists($request->file('screenshot'))) {
                return back()->withErrors(['screenshot' => 'Foto ini sudah pernah diunggah pada fitur Dokumentasi atau Progres Harian.'])->withInput();
            }

            $data['screenshot_path'] = $request
                ->file('screenshot')
                ->store(
                    'daily-progress',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Tambahkan User ID
        |--------------------------------------------------------------------------
        */

        $data['user_id'] = Auth::id();


        /*
        |--------------------------------------------------------------------------
        | Waktu dari sisi klien/browser
        |--------------------------------------------------------------------------
        */

        $clientNow = $this->clientNow($request);

        /*
        |--------------------------------------------------------------------------
        | Simpan Data
        |--------------------------------------------------------------------------
        */

        $dailyProgress = DailyProgress::create($data);

        // created_at/updated_at diisi eksplisit agar tidak terkena mass assignment.
        $dailyProgress->forceFill([
            'created_at' => $clientNow,
            'updated_at' => $clientNow,
        ])->saveQuietly();


        return redirect()
            ->route('daily-progress.index')
            ->with(
                'success',
                'Progres harian berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(DailyProgress $daily_progress)
    {
        abort_unless(
            $daily_progress->user_id === Auth::id(),
            403
        );

        return view('daily.form', [
            'item' => $daily_progress
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        DailyProgress $daily_progress
    ) {
        abort_unless(
            $daily_progress->user_id === Auth::id(),
            403
        );


        $data = $request->validate([
            'date' => 'required|date',
            'short_description' => 'required|string|max:255',
            'detailed_description' => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Screenshot Baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('screenshot')) {

            if (ImageDuplicateChecker::exists($request->file('screenshot'), 'daily', (int) $daily_progress->id)) {
                return back()->withErrors(['screenshot' => 'Foto ini sudah pernah diunggah pada fitur Dokumentasi atau Progres Harian.'])->withInput();
            }

            if ($daily_progress->screenshot_path) {

                Storage::disk('public')->delete(
                    $daily_progress->screenshot_path
                );
            }


            $data['screenshot_path'] = $request
                ->file('screenshot')
                ->store(
                    'daily-progress',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Data
        |--------------------------------------------------------------------------
        */

        $daily_progress->update($data);

        $daily_progress->forceFill([
            'updated_at' => $this->clientNow($request),
        ])->saveQuietly();


        return redirect()
            ->route('daily-progress.index')
            ->with(
                'success',
                'Progres harian berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(DailyProgress $daily_progress)
    {
        abort_unless(
            $daily_progress->user_id === Auth::id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Hapus Screenshot
        |--------------------------------------------------------------------------
        */

        if ($daily_progress->screenshot_path) {

            Storage::disk('public')->delete(
                $daily_progress->screenshot_path
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Hapus Data
        |--------------------------------------------------------------------------
        */

        $daily_progress->delete();


        return back()->with(
            'success',
            'Progres harian berhasil dihapus.'
        );
    }
}