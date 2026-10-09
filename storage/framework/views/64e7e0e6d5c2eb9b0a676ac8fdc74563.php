<?php $__env->startSection('content'); ?>

<div class="container-fluid px-0">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?php echo e(route('final-project.index')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div>
            <h3 class="fw-bold mb-1">
                <?php echo e($task ? 'Edit Kegiatan Proyek Akhir' : 'Tambah Kegiatan Proyek Akhir'); ?>

            </h3>
            <p class="text-muted mb-0">
                <?php echo e($task ? 'Perbarui informasi kegiatan tanpa mengubah riwayat status.' : 'Masukkan kegiatan yang ingin dipantau.'); ?>

            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">

            <form action="<?php echo e($task ? route('final-project.update', $task->id) : route('final-project.store')); ?>"
                  method="POST">

                <?php echo csrf_field(); ?>

                <?php if($task): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>

                <div class="row g-4">

                    <div class="col-lg-8">
                        <label class="form-label fw-semibold">Nama Kegiatan</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="<?php echo e(old('title', $task?->title)); ?>"
                               placeholder="Contoh: Analisis kebutuhan sistem"
                               required>
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date"
                               name="deadline"
                               class="form-control"
                               value="<?php echo e(old('deadline', $task?->deadline?->format('Y-m-d'))); ?>">
                    </div>

                    <?php if(!$task): ?>
                        <div class="col-lg-4">
                            <label class="form-label fw-semibold">Status Awal</label>
                            <select name="status" class="form-select">
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php echo e(old('status', 'Belum') === $status ? 'selected' : ''); ?>>
                                        <?php echo e($status); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="form-text">
                                Perubahan status setelah kegiatan dibuat akan dicatat otomatis.
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Jelaskan pekerjaan atau target kegiatan ini..."><?php echo e(old('description', $task?->description)); ?></textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="<?php echo e(route('final-project.index')); ?>"
                           class="btn btn-outline-secondary">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            <?php echo e($task ? 'Simpan Perubahan' : 'Tambah Kegiatan'); ?>

                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\Sistem_Monitoring_Magang\resources\views/final-project/form.blade.php ENDPATH**/ ?>