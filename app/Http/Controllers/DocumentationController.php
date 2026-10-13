<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\DailyProgress;
use App\Support\ImageDuplicateChecker;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentationController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'latest');
        $search = trim($request->query('search', ''));
        $source = $request->query('source', 'all');
        $allowedSources = ['all', 'documentation', 'daily'];
        if (!in_array($source, $allowedSources, true)) {
            $source = 'all';
        }
        $disk = Storage::disk('public');
        $items = collect();

        // Dokumentasi yang diunggah langsung pada fitur Dokumentasi.
        Documentation::where('user_id', Auth::id())->get()->each(function ($row) use ($items, $disk) {
            if (!$row->image_path || !$disk->exists($row->image_path)) return;
            $row->source_type = 'documentation';
            $row->source_label = 'Dokumentasi';
            $row->gallery_description = $row->description ?: 'Dokumentasi kegiatan magang';
            $items->push($row);
        });

        // Foto/screenshot dari fitur Progres Harian juga tampil di galeri yang sama.
        DailyProgress::where('user_id', Auth::id())->whereNotNull('screenshot_path')->get()->each(function ($row) use ($items, $disk) {
            if (!$row->screenshot_path || !$disk->exists($row->screenshot_path)) return;
            $item = (object) [
                'id' => $row->id,
                'image_path' => $row->screenshot_path,
                'description' => $row->short_description,
                'gallery_description' => $row->short_description . ($row->detailed_description ? ' — ' . $row->detailed_description : ''),
                'created_at' => $row->created_at,
                'source_type' => 'daily',
                'source_label' => 'Progres Harian',
            ];
            $items->push($item);
        });

        // Hilangkan duplikat berdasarkan hash isi file, bukan nama file.
        $seenHashes = [];
        $items = $items->filter(function ($item) use (&$seenHashes, $disk) {
            $fullPath = $disk->path($item->image_path);
            if (!is_file($fullPath)) return false;
            $hash = hash_file('sha256', $fullPath);
            if (isset($seenHashes[$hash])) return false;
            $seenHashes[$hash] = true;
            return true;
        })->values();

        // Filter berdasarkan fitur/sumber unggahan. Hash duplikat tetap diperiksa
        // secara global sebelum filter agar satu gambar tidak muncul berulang.
        if ($source !== 'all') {
            $items = $items->where('source_type', $source)->values();
        }

        if ($search !== '') {
            $needle = mb_strtolower($search);
            $items = $items->filter(fn ($item) => str_contains(mb_strtolower(($item->gallery_description ?? '') . ' ' . ($item->source_label ?? '')), $needle))->values();
        }

        switch ($sort) {
            case 'oldest': $items = $items->sortBy('created_at')->values(); break;
            case 'az': $items = $items->sortBy(fn ($item) => mb_strtolower(trim($item->gallery_description ?? '')))->values(); break;
            case 'za': $items = $items->sortByDesc(fn ($item) => mb_strtolower(trim($item->gallery_description ?? '')))->values(); break;
            case 'week_asc':
                $items = $items->sortBy(function ($item) {
                    return preg_match('/Minggu\s*(\d+)/i', $item->gallery_description ?? '', $m) ? (int) $m[1] : PHP_INT_MAX;
                })->values(); break;
            case 'week_desc':
                $items = $items->sortBy(function ($item) {
                    return preg_match('/Minggu\s*(\d+)/i', $item->gallery_description ?? '', $m) ? -(int) $m[1] : PHP_INT_MAX;
                })->values(); break;
            default: $items = $items->sortByDesc('created_at')->values(); break;
        }

        // Pagination dilakukan setelah seluruh filter dan pengurutan diterapkan.
        // Ini penting karena galeri menggabungkan dua sumber data (Documentation dan DailyProgress).
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage('page');
        $total = $items->count();
        $pageItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $items = new LengthAwarePaginator(
            $pageItems,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
        $items->appends($request->except('page'));

        return view('documentation.index', compact('items', 'sort', 'search', 'source'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'required|string|max:1000',
        ]);

        if (ImageDuplicateChecker::exists($request->file('image'))) {
            return back()->withErrors(['image' => 'Foto ini sudah pernah diunggah pada fitur Dokumentasi atau Progres Harian.'])->withInput();
        }

        $path = $request->file('image')
            ->store('documentation', 'public');

        $clientNow = $this->clientNow($request);

        $documentation = Documentation::create([
            'user_id' => Auth::id(),
            'image_path' => $path,
            'description' => $request->description,
        ]);

        $documentation->forceFill([
            'created_at' => $clientNow,
            'updated_at' => $clientNow,
        ])->saveQuietly();

        return redirect()
            ->route('documentation.index')
            ->with('success', 'Dokumentasi berhasil diupload.');
    }

    public function edit(int $id)
    {
        $documentation = Documentation::where('user_id', Auth::id())->findOrFail($id);

        return view('documentation.edit', compact('documentation'));
    }

    public function update(Request $request, int $id)
    {
        $documentation = Documentation::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $oldPath = $documentation->image_path;
        $newPath = null;

        if ($request->hasFile('image')) {
            if (ImageDuplicateChecker::exists($request->file('image'))) {
                return back()->withErrors([
                    'image' => 'Foto ini sudah pernah diunggah pada fitur Dokumentasi atau Progres Harian.'
                ])->withInput();
            }

            $newPath = $request->file('image')->store('documentation', 'public');
            $validated['image_path'] = $newPath;
        }

        $documentation->update($validated);

        // Hapus foto lama hanya setelah perubahan berhasil disimpan.
        if ($newPath && $oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()->route('documentation.index')
            ->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $documentation = Documentation::where(
            'user_id',
            Auth::id()
        )->findOrFail($id);

        if (
            $documentation->image_path &&
            Storage::disk('public')->exists($documentation->image_path)
        ) {
            Storage::disk('public')->delete(
                $documentation->image_path
            );
        }

        $documentation->delete();

        return redirect()
            ->route('documentation.index')
            ->with('success', 'Dokumentasi berhasil dihapus.');
    }
    
    
    public function download(int $id)
    {
        // Cari dokumentasi milik pengguna yang sedang login
        $documentation = Documentation::where(
            'user_id',
            Auth::id()
        )->findOrFail($id);

        // Pastikan path file tersedia
        if (!$documentation->image_path) {
            abort(404, 'File dokumentasi tidak ditemukan.');
        }

        $disk = Storage::disk('public');

        // Pastikan file tersedia
        if (!$disk->exists($documentation->image_path)) {
            abort(404, 'File dokumentasi tidak ditemukan.');
        }

        // Ambil lokasi file asli
        $path = $disk->path($documentation->image_path);

        // Unduh file
        return response()->download($path);
    }


}