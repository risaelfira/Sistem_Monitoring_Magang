@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="mb-4">

        <h3 class="fw-bold mb-1">

            {{ $item->exists ? 'Edit Progres Mingguan' : 'Tambah Progres Mingguan' }}

        </h3>

        <p class="text-muted mb-0">

            Dokumentasikan kegiatan dan pembelajaran selama satu minggu magang.

        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form
                action="{{ $item->exists
                    ? route('weekly-progress.update', $item->id)
                    : route('weekly-progress.store') }}"
                method="POST"
            >

                @csrf

                @if($item->exists)

                    @method('PUT')

                @endif


                {{-- MINGGU --}}

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Minggu Ke-
                    </label>

                    <input
                        type="number"
                        name="week_number"
                        class="form-control"
                        min="1"
                        value="{{ old('week_number', $item->week_number) }}"
                        required
                    >

                </div>


                <div class="row">

                    {{-- TANGGAL MULAI --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ old('start_date', $item->start_date) }}"
                            required
                        >

                    </div>


                    {{-- TANGGAL SELESAI --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ old('end_date', $item->end_date) }}"
                            required
                        >

                    </div>

                </div>


                {{-- AKTIVITAS --}}

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Aktivitas Mingguan
                    </label>

                    <textarea
                        name="activities"
                        class="form-control"
                        rows="5"
                        placeholder="Tuliskan kegiatan yang dilakukan selama minggu ini..."
                        required
                    >{{ old('activities', $item->activities) }}</textarea>

                </div>


                {{-- INSIGHT --}}

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Insight / Pembelajaran
                    </label>

                    <textarea
                        name="insights"
                        class="form-control"
                        rows="5"
                        placeholder="Tuliskan pengetahuan atau pembelajaran yang diperoleh..."
                        required
                    >{{ old('insights', $item->insights) }}</textarea>

                </div>


                {{-- TUGAS --}}

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Tugas
                    </label>

                    <textarea
                        name="tasks"
                        class="form-control"
                        rows="5"
                        placeholder="Tuliskan tugas yang dikerjakan..."
                        required
                    >{{ old('tasks', $item->tasks) }}</textarea>

                </div>


                {{-- BUTTON --}}

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        {{ $item->exists ? 'Simpan Perubahan' : 'Simpan Progres' }}
                    </button>


                    <a
                        href="{{ route('weekly-progress.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection