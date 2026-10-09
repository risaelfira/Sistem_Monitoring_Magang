@extends('layouts.app')

@section('content')

<div class="container-fluid px-0">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('final-project.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div>
            <h3 class="fw-bold mb-1">
                {{ $task ? 'Edit Kegiatan Proyek Akhir' : 'Tambah Kegiatan Proyek Akhir' }}
            </h3>
            <p class="text-muted mb-0">
                {{ $task ? 'Perbarui informasi kegiatan tanpa mengubah riwayat status.' : 'Masukkan kegiatan yang ingin dipantau.' }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">

            <form action="{{ $task ? route('final-project.update', $task->id) : route('final-project.store') }}"
                  method="POST">

                @csrf

                @if($task)
                    @method('PUT')
                @endif

                <div class="row g-4">

                    <div class="col-lg-8">
                        <label class="form-label fw-semibold">Nama Kegiatan</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $task?->title) }}"
                               placeholder="Contoh: Analisis kebutuhan sistem"
                               required>
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date"
                               name="deadline"
                               class="form-control"
                               value="{{ old('deadline', $task?->deadline?->format('Y-m-d')) }}">
                    </div>

                    @if(!$task)
                        <div class="col-lg-4">
                            <label class="form-label fw-semibold">Status Awal</label>
                            <select name="status" class="form-select">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status', 'Belum') === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                Perubahan status setelah kegiatan dibuat akan dicatat otomatis.
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Jelaskan pekerjaan atau target kegiatan ini...">{{ old('description', $task?->description) }}</textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('final-project.index') }}"
                           class="btn btn-outline-secondary">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ $task ? 'Simpan Perubahan' : 'Tambah Kegiatan' }}
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</div>

@endsection
