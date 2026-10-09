<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentationController extends Controller
{
    public function index()
    {
        $items = Documentation::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('documentation.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'required|string|max:1000',
        ]);

        $path = $request->file('image')
            ->store('documentation', 'public');

        Documentation::create([
            'user_id' => Auth::id(),
            'image_path' => $path,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('documentation.index')
            ->with('success', 'Dokumentasi berhasil diupload.');
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