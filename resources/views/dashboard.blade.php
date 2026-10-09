```blade
@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold mb-1">
        Halo, {{ auth()->user()->name }} 👋
    </h2>
    <p class="text-muted mb-0">
        Pantau perkembangan magang, laporan akhir, dan tugas akhir kamu.
    </p>
</div>

{{-- Ringkasan utama --}}
<div class="row g-3 mb-4">
    @foreach ([
        ['Overall Progress', $overall . '%', 'bi-speedometer2'],
        ['Progres Mingguan', auth()->user()->weeklyProgress()->count() . ' minggu', 'bi-calendar-week'],
        ['Progres Laporan', $reportAvg . '%', 'bi-file-earmark-text'],
        ['Progres Harian', $dailyCount . ' aktivitas', 'bi-code-square']
    ] as $s)
        <div class="col-md-3">
            <div class="card p-3 h-100">
                <div class="text-muted small">{{ $s[0] }}</div>
                <div class="stat mt-1">{{ $s[1] }}</div>
                <i class="bi {{ $s[2] }} fs-4 text-primary mt-2"></i>
            </div>
        </div>
    @endforeach
</div>

{{-- Pemantauan Proyek Akhir --}}
<div class="card p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h5 class="fw-bold mb-1">Pemantauan Proyek Akhir</h5>
            <p class="text-muted small mb-0">
                Ringkasan kegiatan dan status pengerjaan terbaru.
            </p>
        </div>

        <a href="{{ route('final-project.index') }}"
           class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-4">
            <div class="rounded-3 bg-light p-3">
                <div class="small text-muted">Total</div>
                <div class="fs-4 fw-bold">{{ $projectTotal }}</div>
            </div>
        </div>

        <div class="col-4">
            <div class="rounded-3 bg-light p-3">
                <div class="small text-muted">On Progress</div>
                <div class="fs-4 fw-bold text-primary">
                    {{ $projectOnProgress }}
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="rounded-3 bg-light p-3">
                <div class="small text-muted">Done</div>
                <div class="fs-4 fw-bold text-success">
                    {{ $projectDone }}
                </div>
            </div>
        </div>
    </div>

    @forelse ($projectRecent as $task)
        <div class="d-flex justify-content-between align-items-center gap-3 border-top py-2">
            <div class="text-truncate">
                <div class="fw-semibold text-truncate">
                    {{ $task->title }}
                </div>

                <div class="small text-muted">
                    @if ($task->deadline)
                        Deadline {{ $task->deadline->translatedFormat('d M Y') }}
                    @else
                        Tanpa deadline
                    @endif
                </div>
            </div>

            @php
                $statusClass = match ($task->status) {
                    'Done' => 'bg-success',
                    'On Progress' => 'bg-primary',
                    default => 'bg-secondary',
                };
            @endphp

            <span class="badge {{ $statusClass }}">
                {{ $task->status }}
            </span>
        </div>
    @empty
        <div class="text-muted small">
            Belum ada kegiatan proyek akhir.
        </div>
    @endforelse
</div>

{{-- Progres laporan, dokumen, aktivitas, dan dokumentasi --}}
<div class="row g-4">

    <div class="col-lg-7">
        <div class="card p-4">
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold">Progres Laporan Akhir</h5>
                <span class="fw-bold">{{ $reportAvg }}%</span>
            </div>

            <div class="progress my-3">
                <div class="progress-bar"
                    class="progress-bar"
                    role="progressbar"
                    @style(['width' => $reportAvg . '%'])
                    aria-valuenow="{{ (float) $reportAvg }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                    
                </div>
            </div>

            @foreach ($chapters as $c)
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Bab {{ $c->chapter }}</span>
                        <span class="small text-muted">
                            {{ $c->status }} · {{ $c->progress_percentage }}%
                        </span>
                    </div>

                    <div class="progress mt-1">
                        <div class="progress-bar"
                            role="progressbar"
                            @style(['width' => $c->progress_percentage . '%'])
                            aria-valuenow="{{ $c->progress_percentage }}"
                            aria-valuemin="0"
                            aria-valuemax="100"     
                        >
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card p-4">
            <h5 class="fw-bold">Dokumen Sidang</h5>
            <div class="display-6 fw-bold mt-2">
                {{ $docsDone }}/{{ $docsTotal }}
            </div>
            <p class="text-muted">Dokumen selesai</p>

            <a href="{{ route('supporting-documents.index') }}"
               class="btn btn-outline-primary btn-sm">
                Kelola Dokumen
            </a>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>

            @forelse ($recentDaily as $d)
                <div class="border-bottom py-2">
                    <div class="small text-muted">
                        {{ $d->date->format('d M Y') }}
                    </div>
                    <strong>{{ $d->short_description }}</strong>
                </div>
            @empty
                <p class="text-muted">Belum ada progres harian.</p>
            @endforelse
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Dokumentasi Terbaru</h5>

            <div class="row g-2">
                @forelse ($recentDocs as $d)
                    <div class="col-4">
                        <img
                            src="{{ Storage::url($d->image_path) }}"
                            class="thumb"
                            alt="Dokumentasi"
                        >
                    </div>
                @empty
                    <p class="text-muted">Belum ada dokumentasi.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection
```