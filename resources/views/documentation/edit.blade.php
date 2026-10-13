@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Edit Dokumentasi</h3>
            <p class="text-muted mb-0">Ubah keterangan atau ganti foto dokumentasi.</p>
        </div>
        <a href="{{ route('documentation.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <form action="{{ route('documentation.update', $documentation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Foto saat ini</label><br>
                <img src="{{ Storage::url($documentation->image_path) }}" alt="Foto dokumentasi" class="img-fluid rounded border" style="max-height:320px">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Keterangan</label>
                <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $documentation->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label fw-semibold">Ganti foto (opsional)</label>
                <input id="image" name="image" type="file" class="form-control" accept="image/jpeg,image/png,image/webp">
                <small class="text-muted">JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB. Kosongkan jika tidak ingin mengganti foto.</small>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('documentation.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div></div>
</div>
@endsection
