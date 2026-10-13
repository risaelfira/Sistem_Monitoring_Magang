@extends('layouts.app')

@section('content')

<style>

    .documentation-page { max-width: 1440px; margin: 0 auto; }

    .doc-hero { background: linear-gradient(125deg, #173b79 0%, #2563eb 58%, #60a5fa 100%); color: #fff; border-radius: 20px; padding: 26px 28px; box-shadow: 0 10px 28px rgba(37,99,235,.16); }

    .doc-hero p { color: rgba(255,255,255,.82); }

    .doc-panel { border: 1px solid #e8edf5; border-radius: 16px; box-shadow: 0 5px 18px rgba(15,23,42,.045); }

    .doc-section-title { font-weight: 750; letter-spacing: -.02em; color: #172033; }

    .doc-filter-form {
        display: grid;
        grid-template-columns: minmax(180px, 0.9fr) minmax(260px, 1.5fr) minmax(180px, 0.9fr);
        gap: 12px;
        align-items: center;
        width: 100%;
    }

    .doc-filter-form > * { min-width: 0; }

    .doc-filter-form .form-select,
    .doc-filter-form .form-control,
    .doc-filter-form .input-group-text {
        min-width: 0;
        min-height: 44px;
        background: #fff;
        font-size: .92rem;
    }

    .doc-filter-form .form-select {
        width: 100%;
        border-radius: 10px;
        padding: 10px 34px 10px 14px;
    }

    .doc-filter-form .input-group {
        display: flex;
        flex-wrap: nowrap;
        width: 100%;
        min-width: 0;
    }

    .doc-filter-form .input-group-text {
        flex: 0 0 48px;
        justify-content: center;
        padding: 0;
        border-radius: 10px 0 0 10px;
    }

    .doc-filter-form .input-group .form-control {
        flex: 1 1 auto;
        width: 1%;
        border-radius: 0 10px 10px 0;
        padding: 10px 14px;
    }

    .doc-filter-reset {
        display: flex;
        justify-content: flex-end;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #eef2f7;
    }
    .doc-filter-reset a { display: inline-flex; align-items: center; gap: 5px; color: #2563eb; font-size: .85rem; font-weight: 500; text-decoration: none; }
    .doc-filter-reset a:hover { color: #1d4ed8; text-decoration: underline; }

    .doc-card { border: 1px solid #e8edf5 !important; border-radius: 15px !important; transition: transform .18s ease, box-shadow .18s ease; }

    .doc-card:hover { transform: translateY(-3px); box-shadow: 0 12px 26px rgba(15,23,42,.10) !important; }

    .doc-image-wrap { height: 205px; background: #f1f5f9; overflow: hidden; position: relative; }

    .doc-image-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .25s ease; }

    .doc-card:hover .doc-image-wrap img { transform: scale(1.025); }

    .doc-source { font-size: .72rem; font-weight: 700; border-radius: 6px; padding: 5px 8px; }

    .doc-description { color: #273449; font-size: .92rem; line-height: 1.48; overflow-wrap: anywhere; display: -webkit-box; -webkit-line-clamp: 4; line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; min-height: 5.35em; }

    .doc-card-actions { display: flex; flex-wrap: wrap; align-items: stretch; gap: 7px; padding: 0 14px 14px; margin-top: auto; }

    .doc-card-actions > .btn, .doc-card-actions form { flex: 1 1 auto; min-width: 0; }

    .doc-card-actions form .btn { width: 100%; }

    .doc-card-actions .btn { border-radius: 8px; white-space: normal; line-height: 1.25; min-height: 34px; padding: .4rem .55rem; font-size: .82rem; }

    .doc-card-actions .btn i { margin-right: .15rem !important; }

    .doc-card .card-body { min-width: 0; }

    .doc-image-wrap { aspect-ratio: 4 / 3; height: auto; min-height: 150px; max-height: 260px; }

    @media (min-width: 1200px) { .doc-image-wrap { aspect-ratio: 4 / 3; } }

    @media (max-width: 767.98px) { .doc-card-actions { padding: 0 12px 12px; gap: 6px; } .doc-card-actions > .btn, .doc-card-actions form { flex: 1 1 calc(50% - 6px); } .doc-card-actions .btn { font-size: .8rem; padding: .45rem .4rem; } }

    @media (max-width: 400px) { .doc-card-actions > .btn, .doc-card-actions form { flex-basis: 100%; } .doc-card-actions .btn { width: 100%; } }

    .doc-upload-label { font-size: .85rem; font-weight: 650; color: #334155; }

    .doc-empty { border: 1px dashed #cbd5e1; border-radius: 16px; background: #fff; }

    .doc-pagination { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-top:24px; }

    .doc-pagination .pagination { margin:0; }

    .doc-pagination .page-link { border-radius: 8px; margin: 0 2px; border-color: #e2e8f0; color:#2563eb; }

    .doc-pagination .page-item.active .page-link { background:#2563eb; border-color:#2563eb; }

    @media (min-width: 901px) and (max-width: 1100px) { .doc-filter-form { grid-template-columns: minmax(150px, .8fr) minmax(200px, 1.4fr) minmax(150px, .8fr); gap: 9px; } }

    @media (max-width: 900px) { .doc-filter-form { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); } .doc-filter-form .input-group { grid-column: 1 / -1; } }

    @media (max-width: 576px) { .doc-hero { padding:20px; border-radius:15px; } .doc-filter-form { grid-template-columns: minmax(0, 1fr); gap: 10px; } .doc-filter-form .input-group { grid-column: auto; } .doc-filter-reset { justify-content: flex-start; } .doc-image-wrap { height:220px; } .doc-description { min-height:0; } .doc-pagination { align-items:flex-start; } }

</style>

<div class="container-fluid py-4 documentation-page">

    <div class="doc-hero mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">

        <div>

            <div class="small text-uppercase fw-bold mb-2" style="letter-spacing:.12em;">Arsip Aktivitas</div>

            <h2 class="fw-bold mb-2">Dokumentasi Magang</h2>

            <p class="mb-0">Simpan, cari, dan kelola foto kegiatan magang dari satu tempat.</p>

        </div>

        <div class="rounded-3 px-3 py-2" style="background:rgba(255,255,255,.16); min-width:120px;">

            <div class="small">Total foto ditemukan</div>

            <div class="fs-3 fw-bold">{{ $items->total() }}</div>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>

        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-danger" role="alert">

            <strong><i class="bi bi-exclamation-circle me-2"></i>Periksa kembali data yang dimasukkan.</strong>

            <ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>

        </div>

    @endif

    <div class="d-flex justify-content-end mb-4">

        <button type="button" class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#addDocumentationModal">

            <i class="bi bi-plus-lg me-2"></i>Tambah Dokumentasi

        </button>

    </div>

    <div class="modal fade" id="addDocumentationModal" tabindex="-1" aria-labelledby="addDocumentationModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">

            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header border-0 pb-0 px-4 pt-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#eaf1ff;color:#2563eb;flex-shrink:0;"><i class="bi bi-cloud-arrow-up fs-4"></i></div>

                        <div>

                            <h5 class="modal-title doc-section-title mb-1" id="addDocumentationModalLabel">Tambah Dokumentasi</h5>

                            <p class="text-muted small mb-0">Unggah foto dan tambahkan keterangan kegiatan.</p>

                        </div>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>

                </div>

                <form action="{{ route('documentation.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body px-4 py-4">

                        <div class="mb-3">

                            <label for="imageInput" class="form-label doc-upload-label">Foto dokumentasi</label>

                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" required>

                            <div class="form-text">Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.</div>

                            <div id="previewContainer" class="mt-3" style="display:none;">

                                <div class="small fw-semibold mb-2">Pratinjau gambar</div>

                                <div class="rounded-3 overflow-hidden border" style="height:200px;background:#f8fafc;"><img id="imagePreview" src="" alt="Pratinjau foto" style="width:100%;height:100%;object-fit:contain;"></div>

                            </div>

                        </div>

                        <div>

                            <label for="description" class="form-label doc-upload-label">Keterangan kegiatan</label>

                            <textarea name="description" id="description" class="form-control" rows="4" maxlength="1000" placeholder="Contoh: Monitoring jaringan di ruang operasi" required>{{ old('description') }}</textarea>

                            <div class="form-text">Tuliskan aktivitas, hasil pekerjaan, atau konteks foto.</div>

                        </div>

                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 pt-0">

                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>

                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-upload me-2"></i>Upload Foto</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3">

        <div>

            <h4 class="doc-section-title mb-1">Galeri Dokumentasi</h4>

            <p class="text-muted mb-0 small">Gabungan foto dari fitur Dokumentasi dan Progres Harian.</p>

        </div>

        <div class="small text-muted">Menampilkan {{ $items->firstItem() ?? 0 }}–{{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} foto</div>

    </div>

    <div class="card doc-panel border-0 mb-4">

        <div class="card-body p-3">

            <form action="{{ route('documentation.index') }}" method="GET" class="doc-filter-form">

                <select name="source" id="source" class="form-select" aria-label="Filter sumber dokumentasi">

                    <option value="all" @selected($source === 'all')>Semua Sumber</option>

                    <option value="documentation" @selected($source === 'documentation')>File Dokumentasi</option>

                    <option value="daily" @selected($source === 'daily')>File Progres Harian</option>

                </select>

                <div class="input-group">

                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>

                    <input type="search" name="search" class="form-control" placeholder="Cari keterangan..." value="{{ $search }}" aria-label="Cari dokumentasi">

                </div>

                <select name="sort" id="sort" class="form-select" aria-label="Urutkan dokumentasi">

                    <option value="latest" @selected($sort === 'latest')>Terbaru</option>

                    <option value="oldest" @selected($sort === 'oldest')>Terlama</option>

                    <option value="az" @selected($sort === 'az')>Nama A–Z</option>

                    <option value="za" @selected($sort === 'za')>Nama Z–A</option>

                    <option value="week_asc" @selected($sort === 'week_asc')>Minggu 1–20</option>

                    <option value="week_desc" @selected($sort === 'week_desc')>Minggu 20–1</option>

                </select>

            </form>

            @if($search !== '' || $source !== 'all' || $sort !== 'latest')

                <div class="doc-filter-reset"><a href="{{ route('documentation.index') }}"><i class="bi bi-x-circle"></i><span>Reset filter</span></a></div>

            @endif

        </div>

    </div>

    <div class="row g-3 g-lg-4">

        @forelse($items as $item)

            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">

                <article class="card doc-card shadow-sm h-100 overflow-hidden">

                    <div class="doc-image-wrap">

                        @if($item->image_path)

                            <img src="{{ Storage::url($item->image_path) }}" alt="Foto dokumentasi" loading="lazy" onerror="showImageError(this);">

                        @else

                            <div class="h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image fs-1"></i></div>

                        @endif

                    </div>

                    <div class="card-body p-3 d-flex flex-column">

                        <div class="small text-muted mb-2"><i class="bi bi-calendar3 me-1"></i>{{ optional($item->created_at)->format('d M Y, H:i') }}</div>

                        <div class="mb-2"><span class="badge text-bg-light border doc-source"><i class="bi bi-folder2-open me-1"></i>{{ $item->source_label ?? 'Dokumentasi' }}</span></div>

                        <div class="doc-description" title="{{ $item->gallery_description ?? $item->description }}">{{ $item->gallery_description ?? $item->description }}</div>

                    </div>

                    <div class="doc-card-actions">

                        @if(($item->source_type ?? 'documentation') === 'daily')

                            <a href="{{ Storage::url($item->image_path) }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye me-1"></i>Lihat / Unduh</a>

                            <a href="{{ route('daily-progress.edit', $item->id) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil me-1"></i>Buka Progres</a>

                        @else

                            <a href="{{ route('documentation.edit', $item->id) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>

                            <a href="{{ route('documentation.download', $item->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-download me-1"></i>Download</a>

                            <form action="{{ route('documentation.destroy', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">

                                @csrf @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Hapus</button>

                            </form>

                        @endif

                    </div>

                </article>

            </div>

        @empty

            <div class="col-12">

                <div class="doc-empty text-center py-5 px-3">

                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:68px;height:68px;background:#eff6ff;color:#2563eb;"><i class="bi bi-images fs-2"></i></div>

                    <h5 class="fw-bold">Dokumentasi tidak ditemukan</h5>

                    <p class="text-muted mb-3">Belum ada foto yang sesuai dengan sumber atau kata kunci yang dipilih.</p>

                    <a href="{{ route('documentation.index') }}" class="btn btn-outline-primary btn-sm">Tampilkan semua foto</a>

                </div>

            </div>

        @endforelse

    </div>

    @if($items->hasPages())

        <div class="doc-pagination">

            <div class="small text-muted">Halaman {{ $items->currentPage() }} dari {{ $items->lastPage() }}</div>

            <div>{{ $items->onEachSide(1)->links('pagination::bootstrap-5') }}</div>

        </div>

    @endif

</div>

<div id="documentation-page-data"

     data-has-errors="{{ $errors->any() ? '1' : '0' }}"

     hidden></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const pageData = document.getElementById('documentation-page-data');
    const hasErrors = pageData?.dataset.hasErrors === '1';

    if (imageInput && imagePreview && previewContainer) {
        imageInput.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];

            if (!file) {
                previewContainer.style.display = 'none';
                imagePreview.src = '';
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert('File yang dipilih harus berupa gambar.');
                imageInput.value = '';
                previewContainer.style.display = 'none';
                imagePreview.src = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    if (hasErrors) {
        const uploadModalElement = document.getElementById('addDocumentationModal');
        if (uploadModalElement && window.bootstrap) {
            window.bootstrap.Modal.getOrCreateInstance(uploadModalElement).show();
        }
    }

    ['source', 'sort'].forEach(function (id) {
        const element = document.getElementById(id);
        if (element && element.form) {
            element.addEventListener('change', function () {
                element.form.submit();
            });
        }
    });

    // Terapkan pencarian otomatis setelah pengguna berhenti mengetik.
    const searchInput = document.querySelector('.doc-filter-form input[name="search"]');
    if (searchInput && searchInput.form) {
        let searchDelay;
        searchInput.addEventListener('input', function () {
            window.clearTimeout(searchDelay);
            searchDelay = window.setTimeout(function () {
                searchInput.form.submit();
            }, 450);
        });
    }
});

function showImageError(image) {
    image.style.display = 'none';
    image.parentElement.innerHTML =
        '<div class="h-100 d-flex align-items-center justify-content-center text-muted">' +
            '<div class="text-center">' +
                '<i class="bi bi-image fs-1"></i>' +
                '<div class="small mt-2">Gambar tidak ditemukan</div>' +
            '</div>' +
        '</div>';
}
</script>

@endsection
