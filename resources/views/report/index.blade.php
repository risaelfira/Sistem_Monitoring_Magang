@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            Progres Laporan Akhir Magang
        </h3>

        <p class="text-muted mb-0">
            Monitoring pengerjaan laporan akhir magang Bab 1 sampai Bab 5.
        </p>
    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    {{-- TABLE HEADER --}}
                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                Bab
                            </th>

                            <th>
                                Status Pengerjaan
                            </th>

                            <th>
                                Progress
                            </th>

                            <th class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- TABLE BODY --}}
                    <tbody>

                        @forelse($chapters as $chapter)

                            @php

                                $status = $chapter->status ?? 'Belum Dikerjakan';

                                $progress = $chapter->progress_percentage ?? 0;

                                $badge = match($status) {

                                    'Selesai' =>
                                        'bg-success',

                                    'On Progress' =>
                                        'bg-primary',

                                    'Revisi' =>
                                        'bg-warning text-dark',

                                    default =>
                                        'bg-secondary',

                                };

                            @endphp


                            <tr>

                                {{-- BAB --}}
                                <td class="px-4">

                                    <strong>
                                        {{ $chapter->chapter }}
                                    </strong>

                                    <div class="small text-muted">
                                        Laporan Akhir Magang
                                    </div>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    <span class="badge {{ $badge }}">
                                        {{ $status }}
                                    </span>

                                </td>


                                {{-- PROGRESS --}}
                                <td style="width: 250px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div
                                           class="progress flex-grow-1"
                                           style="height: 8px;" 
                                        >
                                        
                                            <div
                                                class="progress-bar progress-dynamic"
                                                role="progressbar"
                                                data-progress="{{ $progress }}"
                                                aria-valuenow="{{ $progress }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                            ></div>

                                            <small class="fw-semibold">
                                                {{ $progress }}%
                                            </small>
                                    </div>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">

                                    <form
                                        action="{{ route('report-progress.update', $chapter->id) }}"
                                        method="POST"
                                        class="d-inline-flex align-items-center gap-2"
                                    >

                                        @csrf


                                        <select
                                            name="status"
                                            class="form-select form-select-sm"
                                            style="width: 170px;"
                                        >

                                            {{-- BELUM DIKERJAKAN --}}
                                            <option
                                                value="Belum Dikerjakan"
                                                {{ $status == 'Belum Dikerjakan' ? 'selected' : '' }}
                                            >
                                                Belum Dikerjakan
                                            </option>


                                            {{-- ON PROGRESS --}}
                                            <option
                                                value="On Progress"
                                                {{ $status == 'On Progress' ? 'selected' : '' }}
                                            >
                                                On Progress
                                            </option>


                                            {{-- REVISI --}}
                                            <option
                                                value="Revisi"
                                                {{ $status == 'Revisi' ? 'selected' : '' }}
                                            >
                                                Revisi
                                            </option>


                                            {{-- SELESAI --}}
                                            <option
                                                value="Selesai"
                                                {{ $status == 'Selesai' ? 'selected' : '' }}
                                            >
                                                Selesai
                                            </option>

                                        </select>


                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-primary"
                                        >
                                            <i class="bi bi-save me-1"></i>
                                            Simpan
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center py-5 text-muted"
                                >

                                    <i class="bi bi-file-earmark-text fs-2 d-block mb-2"></i>

                                    Belum ada data progres laporan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.progress-dynamic').forEach(function (bar) {

        const progress = bar.dataset.progress || 0;

        bar.style.width = progress + '%';

    });

});
</script>

@endpush