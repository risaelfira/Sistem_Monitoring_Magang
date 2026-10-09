@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="supporting-header">

        <h3 class="fw-bold">
            Dokumen Penunjang Sidang Magang
        </h3>

        <a href="{{ route('supporting-documents.create') }}"
        class="btn btn-primary">
            + Tambah Dokumen
        </a>

</div>

    <p class="text-muted mb-4">
        Monitoring dokumen yang diperlukan untuk pelaksanaan sidang magang.
    </p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle supporting-table">

                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 13%;">Nama Dokumen</th>
                            <th style="width: 34%;">Keterangan</th>
                            <th style="width: 13%;">Deadline</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 13%;">Terakhir Diperbarui</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($documents as $index => $document)

                            <tr>

                                {{-- No --}}
                                <td>
                                    {{ $index + 1 }}
                                </td>

                                {{-- Nama Dokumen --}}
                                <td>
                                    <strong>
                                        {{ $document->document_name }}
                                    </strong>
                                </td>

                                {{-- Keterangan --}}
                                <td>
                                    {{ $document->description ?: '-' }}
                                </td>

                                {{-- Deadline --}}
                                <td>
                                    @if($document->deadline)
                                        {{ \Carbon\Carbon::parse($document->deadline)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>

                                    @if($document->status === 'Done')

                                        <span class="badge bg-success">
                                            Done
                                        </span>

                                    @elseif($document->status === 'On Progress')

                                        <span class="badge bg-primary">
                                            On Progress
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Belum
                                        </span>

                                    @endif

                                </td>

                                {{-- Terakhir Diperbarui --}}
                                <td>
                                    {{ $document->updated_at
                                        ? $document->updated_at->format('d M Y')
                                        : '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="{{ route('supporting-documents.edit', $document) }}"
                                        class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('supporting-documents.destroy', $document) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-4">

                                    <p class="text-muted mb-3">
                                        Belum ada dokumen penunjang sidang.
                                    </p>

                                    <a href="{{ route('supporting-documents.create') }}"
                                    class="btn btn-primary">
                                        + Tambahkan Dokumen Pertama
                                    </a>

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