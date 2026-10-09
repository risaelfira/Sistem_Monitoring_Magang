@extends('layouts.app')
@section('content')
<div class="mb-4"><h2 class="fw-bold mb-1">Halo, {{auth()->user()->name}} 👋</h2><p class="text-muted mb-0">Pantau perkembangan magang, laporan akhir, dan tugas akhir kamu.</p></div>
<div class="row g-3 mb-4">
@foreach([['Overall Progress',$overall.'%','bi-speedometer2'],['Progres Mingguan',auth()->user()->weeklyProgress()->count().' minggu','bi-calendar-week'],['Progres Laporan',$reportAvg.'%','bi-file-earmark-text'],['Progres Harian',$dailyCount.' aktivitas','bi-code-square']] as $s)
<div class="col-md-3"><div class="card p-3 h-100"><div class="text-muted small">{{$s[0]}}</div><div class="stat mt-1">{{$s[1]}}</div><i class="bi {{$s[2]}} fs-4 text-primary mt-2"></i></div></div>
@endforeach
</div>
<div class="row g-4">
<div class="col-lg-7"><div class="card p-4"><div class="d-flex justify-content-between"><h5 class="fw-bold">Progres Laporan Akhir</h5><span class="fw-bold">{{$reportAvg}}%</span></div><div class="progress my-3"><div class="progress-bar" style="width:{{$reportAvg}}%"></div></div>@foreach($chapters as $c)<div class="mb-3"><div class="d-flex justify-content-between"><span>Bab {{$c->chapter}}</span><span class="small text-muted">{{$c->status}} · {{$c->progress_percentage}}%</span></div><div class="progress mt-1"><div class="progress-bar" style="width:{{$c->progress_percentage}}%"></div></div></div>@endforeach</div></div>
<div class="col-lg-5"><div class="card p-4"><h5 class="fw-bold">Dokumen Sidang</h5><div class="display-6 fw-bold mt-2">{{$docsDone}}/{{$docsTotal}}</div><p class="text-muted">dokumen selesai</p><a href="{{route('supporting-documents.index')}}" class="btn btn-outline-primary btn-sm">Kelola Dokumen</a></div></div>
<div class="col-lg-7"><div class="card p-4"><h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>@forelse($recentDaily as $d)<div class="border-bottom py-2"><div class="small text-muted">{{$d->date->format('d M Y')}}</div><strong>{{$d->short_description}}</strong></div>@empty<p class="text-muted">Belum ada progres harian.</p>@endforelse</div></div>
<div class="col-lg-5"><div class="card p-4"><h5 class="fw-bold mb-3">Dokumentasi Terbaru</h5><div class="row g-2">@forelse($recentDocs as $d)<div class="col-4"><img src="{{Storage::url($d->image_path)}}" class="thumb" alt="Dokumentasi"></div>@empty<p class="text-muted">Belum ada dokumentasi.</p>@endforelse</div></div></div>
</div>
@endsection