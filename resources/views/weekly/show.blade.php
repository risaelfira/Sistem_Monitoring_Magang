@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

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

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Progres Minggu
                {{ $weeklyProgress->week_number }}

            </h3>

            <p class="text-muted mb-0">

                {{ $weeklyProgress->start_date->format('d M Y') }}
                -
                {{ $weeklyProgress->end_date->format('d M Y') }}

            </p>

        </div>


        <a
            href="{{ route('weekly-progress.index') }}"
            class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>

    </div>


    {{-- RINGKASAN MINGGU --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h6 class="fw-bold">
                        Kegiatan Mingguan
                    </h6>

                    <p class="text-muted mb-0"
                       style="white-space: pre-line;">

                        {{ $weeklyProgress->activities }}

                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h6 class="fw-bold">
                        Insight yang Didapat
                    </h6>

                    <p class="text-muted mb-0"
                       style="white-space: pre-line;">

                        {{ $weeklyProgress->insights }}

                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h6 class="fw-bold">
                        Tugas Mingguan
                    </h6>

                    <p class="text-muted mb-0"
                       style="white-space: pre-line;">

                        {{ $weeklyProgress->tasks }}

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- TAMBAH DETAIL HARIAN --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-1">
                Detail Kegiatan & Tugas Harian
            </h5>

            <p class="text-muted mb-4">
                Tambahkan kegiatan dan tugas yang dilakukan
                pada setiap tanggal.
            </p>


            <form
                action="{{ route('weekly-progress.details.store', $weeklyProgress->id) }}"
                method="POST">

                @csrf

                <div class="row g-3">

                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="date"
                            class="form-control"
                            min="{{ $weeklyProgress->start_date->format('Y-m-d') }}"
                            max="{{ $weeklyProgress->end_date->format('Y-m-d') }}"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Kegiatan Hari Ini
                        </label>

                        <textarea
                            name="activity"
                            class="form-control"
                            rows="3"
                            required
                            placeholder="Apa yang dilakukan hari ini?"></textarea>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tugas Hari Ini
                        </label>

                        <textarea
                            name="task"
                            class="form-control"
                            rows="3"
                            placeholder="Tugas apa yang dikerjakan hari ini?"></textarea>

                    </div>


                    <div class="col-md-1 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="bi bi-plus-lg"></i>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- DETAIL HARIAN --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Riwayat Kegiatan Harian
            </h5>


            @forelse(
                $weeklyProgress->details->sortBy('date')
                as $detail
            )

                <div class="border rounded-3 p-4 mb-3">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="fw-bold mb-1">

                                {{ $detail->date->translatedFormat('l, d F Y') }}

                            </h6>

                        </div>


                        <form
                            action="{{ route('weekly-progress.details.destroy', $detail->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus detail ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-danger">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </div>


                    <hr>


                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="fw-semibold mb-2">
                                Kegiatan
                            </div>

                            <div
                                class="text-muted"
                                style="white-space: pre-line;">

                                {{ $detail->activity }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="fw-semibold mb-2">
                                Tugas
                            </div>

                            <div
                                class="text-muted"
                                style="white-space: pre-line;">

                                {{ $detail->task ?: 'Tidak ada tugas khusus.' }}

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center py-5 text-muted">

                    <i class="bi bi-calendar-x fs-1"></i>

                    <p class="mt-3 mb-0">

                        Belum ada detail kegiatan harian.

                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection