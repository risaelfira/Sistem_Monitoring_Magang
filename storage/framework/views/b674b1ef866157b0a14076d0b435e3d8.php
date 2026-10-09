<?php $__env->startSection('content'); ?>

<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Pemantauan Proyek Akhir</h3>
            <p class="text-muted mb-0">
                Kelola daftar kegiatan proyek akhir dan pantau perubahan status pengerjaannya.
            </p>
        </div>

        <a href="<?php echo e(route('final-project.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Kegiatan
        </a>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">Total Kegiatan</div>
                    <div class="fs-2 fw-bold mt-1"><?php echo e($counts['all']); ?></div>
                    <div class="small text-muted mt-1">seluruh kegiatan proyek</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">Belum</div>
                    <div class="fs-2 fw-bold text-secondary mt-1"><?php echo e($counts['belum']); ?></div>
                    <div class="small text-muted mt-1">belum dikerjakan</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">On Progress</div>
                    <div class="fs-2 fw-bold text-primary mt-1"><?php echo e($counts['on_progress']); ?></div>
                    <div class="small text-muted mt-1">sedang dikerjakan</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="small text-muted">Done</div>
                    <div class="fs-2 fw-bold text-success mt-1"><?php echo e($counts['done']); ?></div>
                    <div class="small text-muted mt-1">sudah selesai</div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">

            <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <?php
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
                ?>

                <div class="p-4 border-bottom">
                    <div class="row g-3 align-items-start">

                        <div class="col-lg-5">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 bg-light p-2 text-primary flex-shrink-0">
                                    <i class="bi bi-check2-square fs-5"></i>
                                </div>

                                <div class="min-w-0">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold mb-0"><?php echo e($task->title); ?></h6>
                                        <span class="badge <?php echo e($badge); ?>"><?php echo e($task->status); ?></span>
                                    </div>

                                    <?php if($task->description): ?>
                                        <div class="text-muted small" style="white-space: pre-line;">
                                            <?php echo e($task->description); ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted small">Tidak ada keterangan.</div>
                                    <?php endif; ?>

                                    <div class="small mt-2 <?php echo e($deadlineClass); ?>">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Deadline:
                                        <?php echo e($task->deadline ? $task->deadline->translatedFormat('d F Y') : 'Tidak ditentukan'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="small text-muted mb-2 fw-semibold">Ubah Status</div>

                            <form action="<?php echo e(route('final-project.status', $task->id)); ?>"
                                  method="POST"
                                  class="d-flex gap-2">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>

                                <select name="status" class="form-select form-select-sm">
                                    <option value="Belum" <?php echo e($task->status === 'Belum' ? 'selected' : ''); ?>>
                                        Belum
                                    </option>
                                    <option value="On Progress" <?php echo e($task->status === 'On Progress' ? 'selected' : ''); ?>>
                                        On Progress
                                    </option>
                                    <option value="Done" <?php echo e($task->status === 'Done' ? 'selected' : ''); ?>>
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
                                        data-bs-target="#history-<?php echo e($task->id); ?>">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Riwayat Status
                                    <span class="badge text-bg-light ms-1">
                                        <?php echo e($task->statusHistories->count()); ?>

                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="d-flex justify-content-lg-end gap-2">
                                <a href="<?php echo e(route('final-project.edit', $task->id)); ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>

                                <form action="<?php echo e(route('final-project.destroy', $task->id)); ?>"
                                      method="POST"
                                      onsubmit="return confirm('Hapus kegiatan ini beserta riwayat statusnya?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    
                    <div class="collapse mt-3" id="history-<?php echo e($task->id); ?>">
                        <div class="rounded-3 bg-light p-3">
                            <div class="fw-semibold mb-2">
                                <i class="bi bi-clock-history me-1"></i>
                                Riwayat Perubahan Status
                            </div>

                            <?php $__empty_2 = true; $__currentLoopData = $task->statusHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <div class="d-flex gap-3 py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
                                    <div class="text-muted small" style="min-width: 145px;">
                                        <?php echo e($history->changed_at->translatedFormat('d F Y')); ?><br>
                                        <?php echo e($history->changed_at->format('H:i')); ?> WIB
                                    </div>

                                    <div class="small">
                                        <span class="badge bg-secondary">
                                            <?php echo e($history->from_status); ?>

                                        </span>

                                        <i class="bi bi-arrow-right mx-1"></i>

                                        <span class="badge
                                            <?php echo e($history->to_status === 'Done'
                                                ? 'bg-success'
                                                : ($history->to_status === 'On Progress'
                                                    ? 'bg-primary'
                                                    : 'bg-secondary')); ?>">
                                            <?php echo e($history->to_status); ?>

                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <div class="text-muted small">
                                    Belum ada perubahan status. Riwayat akan muncul setelah status kegiatan diubah.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-5 px-3">
                    <i class="bi bi-list-check fs-1 text-muted"></i>
                    <h5 class="fw-bold mt-3">Belum ada kegiatan proyek akhir</h5>
                    <p class="text-muted mb-3">
                        Tambahkan kegiatan pertama untuk mulai memantau progres proyek akhir.
                    </p>
                    <a href="<?php echo e(route('final-project.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Tambah Kegiatan
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\Sistem_Monitoring_Magang\resources\views/final-project/index.blade.php ENDPATH**/ ?>