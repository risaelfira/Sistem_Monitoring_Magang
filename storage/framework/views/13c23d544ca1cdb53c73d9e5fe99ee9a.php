<?php $__env->startSection('content'); ?>

<div class="container py-4">

    <div class="supporting-header">

        <h3 class="fw-bold">
            Dokumen Penunjang Sidang Magang
        </h3>

        <a href="<?php echo e(route('supporting-documents.create')); ?>"
        class="btn btn-primary">
            + Tambah Dokumen
        </a>

</div>

    <p class="text-muted mb-4">
        Monitoring dokumen yang diperlukan untuk pelaksanaan sidang magang.
    </p>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

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

                        <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                
                                <td>
                                    <?php echo e($index + 1); ?>

                                </td>

                                
                                <td>
                                    <strong>
                                        <?php echo e($document->document_name); ?>

                                    </strong>
                                </td>

                                
                                <td>
                                    <?php echo e($document->description ?: '-'); ?>

                                </td>

                                
                                <td>
                                    <?php if($document->deadline): ?>
                                        <?php echo e(\Carbon\Carbon::parse($document->deadline)->format('d M Y')); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                
                                <td>

                                    <?php if($document->status === 'Done'): ?>

                                        <span class="badge bg-success">
                                            Done
                                        </span>

                                    <?php elseif($document->status === 'On Progress'): ?>

                                        <span class="badge bg-primary">
                                            On Progress
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary">
                                            Belum
                                        </span>

                                    <?php endif; ?>

                                </td>

                                
                                <td>
                                    <?php echo e($document->updated_at
                                        ? $document->updated_at->format('d M Y')
                                        : '-'); ?>

                                </td>

                                
                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="<?php echo e(route('supporting-documents.edit', $document)); ?>"
                                        class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="<?php echo e(route('supporting-documents.destroy', $document)); ?>"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td colspan="7" class="text-center py-4">

                                    <p class="text-muted mb-3">
                                        Belum ada dokumen penunjang sidang.
                                    </p>

                                    <a href="<?php echo e(route('supporting-documents.create')); ?>"
                                    class="btn btn-primary">
                                        + Tambahkan Dokumen Pertama
                                    </a>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\Sistem_Monitoring_Magang\resources\views/supporting/index.blade.php ENDPATH**/ ?>