```blade


<?php $__env->startSection('content'); ?>

<div class="mb-4">
    <h2 class="fw-bold mb-1">
        Halo, <?php echo e(auth()->user()->name); ?> 👋
    </h2>
    <p class="text-muted mb-0">
        Pantau perkembangan magang, laporan akhir, dan tugas akhir kamu.
    </p>
</div>


<div class="row g-3 mb-4">
    <?php $__currentLoopData = [
        ['Overall Progress', $overall . '%', 'bi-speedometer2'],
        ['Progres Mingguan', auth()->user()->weeklyProgress()->count() . ' minggu', 'bi-calendar-week'],
        ['Progres Laporan', $reportAvg . '%', 'bi-file-earmark-text'],
        ['Progres Harian', $dailyCount . ' aktivitas', 'bi-code-square']
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <div class="card p-3 h-100">
                <div class="text-muted small"><?php echo e($s[0]); ?></div>
                <div class="stat mt-1"><?php echo e($s[1]); ?></div>
                <i class="bi <?php echo e($s[2]); ?> fs-4 text-primary mt-2"></i>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="card p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h5 class="fw-bold mb-1">Pemantauan Proyek Akhir</h5>
            <p class="text-muted small mb-0">
                Ringkasan kegiatan dan status pengerjaan terbaru.
            </p>
        </div>

        <a href="<?php echo e(route('final-project.index')); ?>"
           class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-4">
            <div class="rounded-3 bg-light p-3">
                <div class="small text-muted">Total</div>
                <div class="fs-4 fw-bold"><?php echo e($projectTotal); ?></div>
            </div>
        </div>

        <div class="col-4">
            <div class="rounded-3 bg-light p-3">
                <div class="small text-muted">On Progress</div>
                <div class="fs-4 fw-bold text-primary">
                    <?php echo e($projectOnProgress); ?>

                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="rounded-3 bg-light p-3">
                <div class="small text-muted">Done</div>
                <div class="fs-4 fw-bold text-success">
                    <?php echo e($projectDone); ?>

                </div>
            </div>
        </div>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $projectRecent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="d-flex justify-content-between align-items-center gap-3 border-top py-2">
            <div class="text-truncate">
                <div class="fw-semibold text-truncate">
                    <?php echo e($task->title); ?>

                </div>

                <div class="small text-muted">
                    <?php if($task->deadline): ?>
                        Deadline <?php echo e($task->deadline->translatedFormat('d M Y')); ?>

                    <?php else: ?>
                        Tanpa deadline
                    <?php endif; ?>
                </div>
            </div>

            <?php
                $statusClass = match ($task->status) {
                    'Done' => 'bg-success',
                    'On Progress' => 'bg-primary',
                    default => 'bg-secondary',
                };
            ?>

            <span class="badge <?php echo e($statusClass); ?>">
                <?php echo e($task->status); ?>

            </span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-muted small">
            Belum ada kegiatan proyek akhir.
        </div>
    <?php endif; ?>
</div>


<div class="row g-4">

    <div class="col-lg-7">
        <div class="card p-4">
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold">Progres Laporan Akhir</h5>
                <span class="fw-bold"><?php echo e($reportAvg); ?>%</span>
            </div>

            <div class="progress my-3">
                <div class="progress-bar"
                    class="progress-bar"
                    role="progressbar"
                    style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => $reportAvg . '%']) ?>"
                    aria-valuenow="<?php echo e((float) $reportAvg); ?>"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                    
                </div>
            </div>

            <?php $__currentLoopData = $chapters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Bab <?php echo e($c->chapter); ?></span>
                        <span class="small text-muted">
                            <?php echo e($c->status); ?> · <?php echo e($c->progress_percentage); ?>%
                        </span>
                    </div>

                    <div class="progress mt-1">
                        <div class="progress-bar"
                            role="progressbar"
                            style="<?php echo \Illuminate\Support\Arr::toCssStyles(['width' => $c->progress_percentage . '%']) ?>"
                            aria-valuenow="<?php echo e($c->progress_percentage); ?>"
                            aria-valuemin="0"
                            aria-valuemax="100"     
                        >
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card p-4">
            <h5 class="fw-bold">Dokumen Sidang</h5>
            <div class="display-6 fw-bold mt-2">
                <?php echo e($docsDone); ?>/<?php echo e($docsTotal); ?>

            </div>
            <p class="text-muted">Dokumen selesai</p>

            <a href="<?php echo e(route('supporting-documents.index')); ?>"
               class="btn btn-outline-primary btn-sm">
                Kelola Dokumen
            </a>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>

            <?php $__empty_1 = true; $__currentLoopData = $recentDaily; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="border-bottom py-2">
                    <div class="small text-muted">
                        <?php echo e($d->date->format('d M Y')); ?>

                    </div>
                    <strong><?php echo e($d->short_description); ?></strong>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-muted">Belum ada progres harian.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Dokumentasi Terbaru</h5>

            <div class="row g-2">
                <?php $__empty_1 = true; $__currentLoopData = $recentDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-4">
                        <img
                            src="<?php echo e(Storage::url($d->image_path)); ?>"
                            class="thumb"
                            alt="Dokumentasi"
                        >
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">Belum ada dokumentasi.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
```
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\Sistem_Monitoring_Magang\resources\views/dashboard.blade.php ENDPATH**/ ?>