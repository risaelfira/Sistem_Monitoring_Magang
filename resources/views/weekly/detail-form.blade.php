@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold">Edit Detail Kegiatan — Minggu {{ $weeklyProgress->week_number }}</h3>
        <p class="text-muted">Perbarui tanggal, kegiatan, dan tugas harian.</p>
    </div>
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <form action="{{ route('weekly-progress.details.update', $detail->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="date" class="form-control" min="{{ $weeklyProgress->start_date->format('Y-m-d') }}" max="{{ $weeklyProgress->end_date->format('Y-m-d') }}" value="{{ old('date', $detail->date->format('Y-m-d')) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kegiatan Hari Ini</label>
                <textarea name="activity" class="form-control" rows="5" required>{{ old('activity', $detail->activity) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tugas Hari Ini</label>
                <textarea name="task" class="form-control" rows="4">{{ old('task', $detail->task) }}</textarea>
            </div>
            <button class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('weekly-progress.show', $weeklyProgress->id) }}" class="btn btn-light">Batal</a>
        </form>
    </div></div>
</div>
@endsection
