@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Dokumentasi Magang
        </h3>

        <p class="text-muted mb-0">
            Upload foto kegiatan magang. Tanggal upload dicatat secara otomatis.
        </p>

    </div>


    {{-- ERROR --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ============================= --}}
    {{-- FORM UPLOAD --}}
    {{-- ============================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">
                Tambah Dokumentasi
            </h5>

            <form
                action="{{ route('documentation.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="row g-4">

                    {{-- KOLOM FOTO --}}
                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Foto
                        </label>

                        <input
                            type="file"
                            name="image"
                            id="imageInput"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            required>

                        <small class="text-muted d-block mt-2">
                            JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </small>


                        {{-- PREVIEW --}}
                        <div
                            id="previewContainer"
                            class="mt-3"
                            style="display: none;">

                            <label class="form-label fw-semibold">
                                Preview
                            </label>

                            <div
                                class="border rounded overflow-hidden"
                                style="
                                    width: 100%;
                                    height: 220px;
                                    background: #f8f9fa;
                                ">

                                <img
                                    id="imagePreview"
                                    src=""
                                    alt="Preview"
                                    style="
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                    ">

                            </div>

                        </div>

                    </div>


                    {{-- KOLOM KETERANGAN --}}
                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Keterangan
                        </label>

                        <input
                            type="text"
                            name="description"
                            class="form-control"
                            placeholder="Contoh: Monitoring jaringan di ruang operasi"
                            value="{{ old('description') }}"
                            required>

                    </div>


                    {{-- BUTTON --}}
                    <div class="col-md-2 d-flex align-items-start">

                        <div class="w-100">

                            <label class="form-label d-block">
                                &nbsp;
                            </label>

                            <button
                                type="submit"
                                class="btn btn-primary w-100">

                                <i class="bi bi-upload me-1"></i>
                                Upload

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- DAFTAR DOKUMENTASI --}}
    {{-- ============================= --}}

    <div class="mb-3">

        <h5 class="fw-bold mb-1">
            Dokumentasi Saya
        </h5>

        <p class="text-muted mb-0">
            Dokumentasi kegiatan magang yang telah diupload.
        </p>

    </div>


    <div class="row g-4">

        @forelse($items as $item)

            <div class="col-md-6 col-lg-4">

                <div
                    class="card border-0 shadow-sm h-100 overflow-hidden">


                    {{-- ================= --}}
                    {{-- GAMBAR --}}
                    {{-- ================= --}}

                    @if($item->image_path)

                        <div
                            style="
                                height: 230px;
                                background: #f8f9fa;
                                overflow: hidden;
                            ">

                            <img
                                src="{{ asset('storage/' . $item->image_path) }}"
                                alt="Dokumentasi Magang"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                "
                                onerror="showImageError(this);">

                        </div>

                    @else

                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                height: 230px;
                                background: #f8f9fa;
                            ">

                            <div class="text-center text-muted">

                                <i
                                    class="bi bi-image"
                                    style="font-size: 45px;">
                                </i>

                                <div class="mt-2">
                                    Tidak ada gambar
                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- ================= --}}
                    {{-- INFORMASI --}}
                    {{-- ================= --}}

                    <div class="card-body p-2">

                        <div class="small text-muted mb-2">

                            <i class="bi bi-calendar3 me-1"></i>

                            {{ $item->created_at->format('d M Y, H:i') }}

                        </div>


                        <div class="fw-semibold">

                            {{ $item->description }}

                        </div>

                    </div>


                    {{-- ================= --}}
                    {{-- DOWNLOAD & DELETE --}}
                    {{-- ================= --}}

                    <div 
                    class="d-flex align-items-center gap-2 p-3"
                    style="position: relative; top: -8px;"
                    >
                        {{-- Download --}}
                        <a
                            href="{{ route('documentation.download', $item->id) }}"
                            class="btn btn-outline-primary btn-sm"
                        >
                            <i class="bi bi-download me-1"></i>
                            Download
                        </a>
                    
                        {{-- Delete --}}      
                        <form
                            action="{{ route('documentation.destroy', $item->id) }}"
                            method="POST"
                            class="m-0"
                            onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-danger"
                            >
                                <i class="bi bi-trash me-1"></i>
                                Delete
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i
                            class="bi bi-images"
                            style="font-size: 50px;">
                        </i>

                        <h5 class="fw-bold mt-3">
                            Belum ada dokumentasi
                        </h5>

                        <p class="text-muted mb-0">
                            Upload dokumentasi kegiatan magang menggunakan form di atas.
                        </p>

                        <div class="card-body pb-3">

                    </div>

                </div>

            </div>

        @endforelse

    </div>

</div>


{{-- ============================= --}}
{{-- JAVASCRIPT PREVIEW --}}
{{-- ============================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');


    imageInput.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) {

            previewContainer.style.display = 'none';

            imagePreview.src = '';

            return;

        }


        // Pastikan file adalah gambar
        if (!file.type.startsWith('image/')) {

            alert('File yang dipilih harus berupa gambar.');

            imageInput.value = '';

            previewContainer.style.display = 'none';

            return;

        }


        // Preview menggunakan FileReader
        const reader = new FileReader();


        reader.onload = function (e) {

            imagePreview.src = e.target.result;

            previewContainer.style.display = 'block';

        };


        reader.readAsDataURL(file);

    });

});


/*
|--------------------------------------------------------------------------
| Jika gambar dokumentasi lama rusak
|--------------------------------------------------------------------------
*/

function showImageError(image) {

    image.style.display = 'none';

    const parent = image.parentElement;

    parent.innerHTML = `
        <div
            class="d-flex align-items-center justify-content-center"
            style="
                width: 100%;
                height: 100%;
                color: #6c757d;
            "
        >
            <div class="text-center">

                <i
                    class="bi bi-image"
                    style="font-size: 45px;"
                ></i>

                <div class="mt-2">
                    Gambar tidak ditemukan
                </div>

            </div>
        </div>
    `;
}

</script>

@endsection