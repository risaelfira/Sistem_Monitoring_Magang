<?php

namespace App\Http\Controllers;

use App\Models\SupportingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportingDocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen sidang
     */
    public function index()
    {
        $documents = SupportingDocument::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('supporting.index', compact('documents'));
    }

    /**
     * Menampilkan form tambah dokumen
     */
    public function create()
    {
        $item = new SupportingDocument();

        return view('supporting.form', compact('item'));
    }

    /**
     * Menyimpan dokumen baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'deadline'      => 'nullable|date',
            'status'        => 'required|in:Belum,On Progress,Done',
        ]);

        $validated['user_id'] = Auth::id();

        SupportingDocument::create($validated);

        return redirect()
            ->route('supporting-documents.index')
            ->with('success', 'Dokumen sidang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit dokumen
     */
    public function edit(SupportingDocument $supportingDocument)
    {
        // Pastikan dokumen milik user yang sedang login
        abort_if(
            $supportingDocument->user_id !== Auth::id(),
            403
        );

        $item = $supportingDocument;

        return view('supporting.form', compact('item'));
    }

    /**
     * Memperbarui dokumen
     */
    public function update(
        Request $request,
        SupportingDocument $supportingDocument
    ) {
        // Pastikan dokumen milik user yang sedang login
        abort_if(
            $supportingDocument->user_id !== Auth::id(),
            403
        );

        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'deadline'      => 'nullable|date',
            'status'        => 'required|in:Belum,On Progress,Done',
        ]);

        $supportingDocument->update($validated);

        return redirect()
            ->route('supporting-documents.index')
            ->with('success', 'Dokumen sidang berhasil diperbarui.');
    }

    /**
     * Menghapus dokumen
     */
    public function destroy(SupportingDocument $supportingDocument)
    {
        // Pastikan dokumen milik user yang sedang login
        abort_if(
            $supportingDocument->user_id !== Auth::id(),
            403
        );

        $supportingDocument->delete();

        return redirect()
            ->route('supporting-documents.index')
            ->with('success', 'Dokumen sidang berhasil dihapus.');
    }
}