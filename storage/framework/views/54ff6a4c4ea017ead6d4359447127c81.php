<?php $__env->startSection('content'); ?>

<div class="container py-4">

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>


    
    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Progres Mingguan Magang
        </h3>

        <p class="text-muted mb-0">
            Catat kegiatan, insight, dan tugas yang diperoleh
            selama setiap minggu magang.
        </p>

    </div>


    
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Tambah Progres Mingguan
            </h5>

            <form
                action="<?php echo e(route('weekly-progress.store')); ?>"
                method="POST">

                <?php echo csrf_field(); ?>

                <div class="row g-3">

                    
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
                            value="<?php echo e(old('week_number')); ?>"
                            placeholder="Contoh: 1">

                    </div>


                    
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            required
                            value="<?php echo e(old('start_date')); ?>">

                    </div>


                    
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            required
                            value="<?php echo e(old('end_date')); ?>">

                    </div>


                    
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Kegiatan Mingguan
                        </label>

                        <textarea
                            name="activities"
                            class="form-control"
                            rows="5"
                            required
                            placeholder="Tuliskan kegiatan utama selama minggu ini..."><?php echo e(old('activities')); ?></textarea>

                    </div>


                    
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Insight yang Didapat
                        </label>

                        <textarea
                            name="insights"
                            class="form-control"
                            rows="5"
                            required
                            placeholder="Tuliskan pengetahuan atau insight yang diperoleh..."><?php echo e(old('insights')); ?></textarea>

                    </div>


                    
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Tugas Mingguan
                        </label>

                        <textarea
                            name="tasks"
                            class="form-control"
                            rows="5"
                            required
                            placeholder="Tuliskan tugas yang diberikan selama minggu ini..."><?php echo e(old('tasks')); ?></textarea>

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


    
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Riwayat Progres Mingguan
            </h5>


            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="border rounded-3 p-4 mb-3">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <h5 class="fw-bold mb-1">

                                Minggu <?php echo e($item->week_number); ?>


                            </h5>

                            <div class="text-muted small">

                                <?php echo e($item->start_date->format('d M Y')); ?>

                                -
                                <?php echo e($item->end_date->format('d M Y')); ?>


                            </div>

                        </div>


                        <div class="d-flex gap-2">

                            <a
                                href="<?php echo e(route('weekly-progress.show', $item->id)); ?>"
                                class="btn btn-sm btn-primary">

                                <i class="bi bi-eye me-1"></i>
                                Detail

                            </a>


                            <form
                                action="<?php echo e(route('weekly-progress.destroy', $item->id)); ?>"
                                method="POST"
                                onsubmit="return confirm('Hapus progres minggu ini?')">

                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

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
                                <?php echo e(Str::limit($item->activities, 150)); ?>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="small text-muted mb-1">
                                Insight
                            </div>

                            <div>
                                <?php echo e(Str::limit($item->insights, 150)); ?>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="small text-muted mb-1">
                                Tugas
                            </div>

                            <div>
                                <?php echo e(Str::limit($item->tasks, 150)); ?>

                            </div>

                        </div>

                    </div>


                    <div class="mt-3">

                        <span class="badge bg-primary">

                            <?php echo e($item->details->count()); ?>

                            detail kegiatan harian

                        </span>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="text-center py-5 text-muted">

                    <i class="bi bi-calendar-week fs-1"></i>

                    <p class="mt-3 mb-0">
                        Belum ada progres mingguan.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\Sistem_Monitoring_Magang\resources\views/weekly/index.blade.php ENDPATH**/ ?>