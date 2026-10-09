@extends('layouts.app')

@section('content')

<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Pemantauan Proyek Akhir</h3>
            <p class="text-muted mb-0">
                Kelola daftar kegiatan proyek akhir dan pantau perubahan status pengerjaannya.
            </p>
        </div>

        <a href="{{ route('final-project.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Kegiatan
        </a>
    </div>

    {{-- RINGKASAN STATUS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">Total Kegiatan</div>
                    <div class="fs-2 fw-bold mt-1">{{ $counts['all'] }}</div>
                    <div class="small text-muted mt-1">seluruh kegiatan proyek</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">Belum</div>
                    <div class="fs-2 fw-bold text-secondary mt-1">{{ $counts['belum'] }}</div>
                    <div class="small text-muted mt-1">belum dikerjakan</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">On Progress</div>
                    <div class="fs-2 fw-bold text-primary mt-1">{{ $counts['on_progress'] }}</div>
                    <div class="small text-muted mt-1">sedang dikerjakan</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">Done</div>
                    <div class="fs-2 fw-bold text-success mt-1">{{ $counts['done'] }}</div>
                    <div class="small text-muted mt-1">sudah selesai</div>
                </div>
            </div>
        </div>
    </div>

    {{-- DAFTAR KEGIATAN --}}
    <div class="card">
        <div class="card-body p-0">

            @forelse($tasks as $task)

                @php
                    $badge = match($task->status) {
                        'Done' => 'bg-success',
                        'On Progress' => 'bg-primary',
                        default => 'bg-secondary',
                    };

                    $deadlineClass = '';
                    if ($task->deadline) {
                        if ($task->deadline->isPast() && $task->status !== 'Done') {
                            $deadlineClass = 'text-danger fw-semibold';
                        } elseif ($task->deadline->isToday()) {
                            $deadlineClass = 'text-warning fw-semibold';
                        }
                    }
                @endphp

                <div class="p-4 border-bottom">
                    <div class="row g-3 align-items-start">

                        <div class="col-lg-5">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 bg-light p-2 text-primary flex-shrink-0">
                                    <i class="bi bi-check2-square fs-5"></i>
                                </div>

                                <div class="min-w-0">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold mb-0">{{ $task->title }}</h6>
                                        <span class="badge {{ $badge }}">{{ $task->status }}</span>
                                    </div>

                                    @if($task->description)
                                        <div class="text-muted small" style="white-space: pre-line;">
                                            {{ $task->description }}
                                        </div>
                                    @else
                                        <div class="text-muted small">Tidak ada keterangan.</div>
                                    @endif

                                    <div class="small mt-2 {{ $deadlineClass }}">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Deadline:
                                        {{ $task->deadline ? $task->deadline->translatedFormat('d F Y') : 'Tidak ditentukan' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="small text-muted mb-2 fw-semibold">Ubah Status</div>

                            <form action="{{ route('final-project.status', $task->id) }}"
                                  method="POST"
                                  class="d-flex gap-2">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="form-select form-select-sm">
                                    <option value="Belum" {{ $task->status === 'Belum' ? 'selected' : '' }}>
                                        Belum
                                    </option>
                                    <option value="On Progress" {{ $task->status === 'On Progress' ? 'selected' : '' }}>
                                        On Progress
                                    </option>
                                    <option value="Done" {{ $task->status === 'Done' ? 'selected' : '' }}>
                                        Done
                                    </option>
                                </select>

                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-save me-1"></i>Simpan
                                </button>
                            </form>

                            <div class="mt-2">
                                <button class="btn btn-sm btn-link p-0 text-decoration-none"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#history-{{ $task->id }}">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Riwayat Status
                                    <span class="badge text-bg-light ms-1">
                                        {{ $task->statusHistories->count() }}
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="d-flex justify-content-lg-end gap-2">
                                <a href="{{ route('final-project.edit', $task->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>

                                <form action="{{ route('final-project.destroy', $task->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus kegiatan ini beserta riwayat statusnya?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- RIWAYAT PERUBAHAN STATUS --}}
                    <div class="collapse mt-3" id="history-{{ $task->id }}">
                        <div class="rounded-3 bg-light p-3">
                            <div class="fw-semibold mb-2">
                                <i class="bi bi-clock-history me-1"></i>
                                Riwayat Perubahan Status
                            </div>

                            @forelse($task->statusHistories as $history)
                                <div class="d-flex gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="text-muted small" style="min-width: 145px;">
                                        {{ $history->changed_at->translatedFormat('d F Y') }}<br>
                                        {{ $history->changed_at->format('H:i') }} WIB
                                    </div>

                                    <div class="small">
                                        <span class="badge bg-secondary">
                                            {{ $history->from_status }}
                                        </span>

                                        <i class="bi bi-arrow-right mx-1"></i>

                                        <span class="badge
                                            {{ $history->to_status === 'Done'
                                                ? 'bg-success'
                                                : ($history->to_status === 'On Progress'
                                                    ? 'bg-primary'
                                                    : 'bg-secondary') }}">
                                            {{ $history->to_status }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted small">
                                    Belum ada perubahan status. Riwayat akan muncul setelah status kegiatan diubah.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            @empty
                <div class="text-center py-5 px-3">
                    <i class="bi bi-list-check fs-1 text-muted"></i>
                    <h5 class="fw-bold mt-3">Belum ada kegiatan proyek akhir</h5>
                    <p class="text-muted mb-3">
                        Tambahkan kegiatan pertama untuk mulai memantau progres proyek akhir.
                    </p>
                    <a href="{{ route('final-project.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Tambah Kegiatan
                    </a>
                </div>
            @endforelse

        </div>
    </div>

</div>

@endsection
