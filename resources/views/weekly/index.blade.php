@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- HEADER --}}
    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Progres Mingguan Magang
        </h3>

        <p class="text-muted mb-0">
            Catat kegiatan, insight, dan tugas yang diperoleh
            selama setiap minggu magang.
        </p>

    </div>


    {{-- TAMBAH MINGGU --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Tambah Progres Mingguan
            </h5>

            <form
                action="{{ route('weekly-progress.store') }}"
                method="POST">

                @csrf

                <div class="row g-3">

                    {{-- MINGGU --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Minggu Ke-
                        </label>

                        <input
                            type="number"
                            name="week_number"
                            class="form-control"
                            min="1"
                            required
                            value="{{ old('week_number') }}"
                            placeholder="Contoh: 1">

                    </div>


                    {{-- TANGGAL MULAI --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            required
                            value="{{ old('start_date') }}">

                    </div>


                    {{-- TANGGAL SELESAI --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            required
                            value="{{ old('end_date') }}">

                    </div>


                    {{-- KEGIATAN --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Kegiatan Mingguan
                        </label>

                        <textarea
                            name="activities"
                            class="form-control"
                            rows="5"
                            required
                            placeholder="Tuliskan kegiatan utama selama minggu ini...">{{ old('activities') }}</textarea>

                    </div>


                    {{-- INSIGHT --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Insight yang Didapat
                        </label>

                        <textarea
                            name="insights"
                            class="form-control"
                            rows="5"
                            required
                            placeholder="Tuliskan pengetahuan atau insight yang diperoleh...">{{ old('insights') }}</textarea>

                    </div>


                    {{-- TUGAS --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tugas Mingguan
                        </label>

                        <textarea
                            name="tasks"
                            class="form-control"
                            rows="5"
                            required
                            placeholder="Tuliskan tugas yang diberikan selama minggu ini...">{{ old('tasks') }}</textarea>

                    </div>


                    <div class="col-12">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-plus-circle me-1"></i>

                            Simpan Progres Minggu

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- DAFTAR MINGGU --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Riwayat Progres Mingguan
            </h5>


            @forelse($items as $item)

                <div class="border rounded-3 p-4 mb-3">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <h5 class="fw-bold mb-1">

                                Minggu {{ $item->week_number }}

                            </h5>

                            <div class="text-muted small">

                                {{ $item->start_date->format('d M Y') }}
                                -
                                {{ $item->end_date->format('d M Y') }}

                            </div>

                        </div>


                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('weekly-progress.show', $item->id) }}"
                                class="btn btn-sm btn-primary">

                                <i class="bi bi-eye me-1"></i>
                                Detail

                            </a>


                            <form
                                action="{{ route('weekly-progress.destroy', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus progres minggu ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </div>

                    </div>


                    <hr>


                    <div class="row g-3">

                        <div class="col-md-4">

                            <div class="small text-muted mb-1">
                                Kegiatan
                            </div>

                            <div>
                                {{ Str::limit($item->activities, 150) }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="small text-muted mb-1">
                                Insight
                            </div>

                            <div>
                                {{ Str::limit($item->insights, 150) }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="small text-muted mb-1">
                                Tugas
                            </div>

                            <div>
                                {{ Str::limit($item->tasks, 150) }}
                            </div>

                        </div>

                    </div>


                    <div class="mt-3">

                        <span class="badge bg-primary">

                            {{ $item->details->count() }}
                            detail kegiatan harian

                        </span>

                    </div>

                </div>

            @empty

                <div class="text-center py-5 text-muted">

                    <i class="bi bi-calendar-week fs-1"></i>

                    <p class="mt-3 mb-0">
                        Belum ada progres mingguan.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection