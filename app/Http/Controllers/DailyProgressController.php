<?php

namespace App\Http\Controllers;

use App\Models\DailyProgress;
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

    public function index()
    {
        $items = DailyProgress::where(
            'user_id',
            Auth::id()
        )
        ->latest('date')
        ->paginate(10);

        return view(
            'daily.index',
            compact('items')
        );
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
        | Simpan Data
        |--------------------------------------------------------------------------
        */

        DailyProgress::create($data);


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