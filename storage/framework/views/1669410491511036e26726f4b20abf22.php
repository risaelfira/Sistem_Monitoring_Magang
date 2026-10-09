<?php $__env->startSection('content'); ?>

<style>

    /* =========================================================
       DAILY PROGRESS PAGE
    ========================================================= */

    .daily-page {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .daily-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 24px;

        margin-bottom: 24px;
    }

    .daily-page-title {
        min-width: 0;
    }

    .daily-page-title h3 {
        margin: 0 0 6px 0;

        font-size: 28px;
        line-height: 1.25;

        font-weight: 800;

        color: #172033;

        overflow-wrap: anywhere;
    }

    .daily-page-title p {
        margin: 0;

        color: #64748b;

        font-size: 16px;
        line-height: 1.5;
    }

    .daily-add-button {
        flex-shrink: 0;

        white-space: nowrap;

        padding: 10px 18px;

        border-radius: 8px;

        font-weight: 600;
    }


    /* =========================================================
       DAILY ITEM
    ========================================================= */

    .daily-item {
        background: #ffffff;

        border-radius: 16px;

        padding: 28px;

        margin-bottom: 16px;

        box-shadow:
            0 4px 20px rgba(15, 23, 42, 0.06);

        display: grid;

        grid-template-columns:
            150px
            minmax(0, 1fr)
            auto;

        column-gap: 28px;

        align-items: center;

        width: 100%;

        min-width: 0;
    }


    /* =========================================================
       DATE
    ========================================================= */

    .daily-date {
        min-width: 0;
    }

    .daily-date-date {
        color: #64748b;

        font-size: 14px;

        line-height: 1.4;

        margin-bottom: 4px;

        white-space: nowrap;
    }

    .daily-date-day {
        color: #172033;

        font-size: 18px;

        font-weight: 700;

        line-height: 1.3;
    }


    /* =========================================================
       DESCRIPTION
    ========================================================= */

    .daily-content {
        min-width: 0;

        overflow: hidden;
    }

    .daily-content-title {
        margin: 0 0 10px 0;

        color: #252525;

        font-size: 21px;

        font-weight: 800;

        line-height: 1.3;

        overflow-wrap: anywhere;

        word-break: normal;
    }

    .daily-content-description {
        margin: 0;

        color: #6b7280;

        font-size: 16px;

        line-height: 1.6;

        overflow-wrap: anywhere;

        word-break: normal;
    }


    /* =========================================================
       ACTIONS
    ========================================================= */

    .daily-actions {
        min-width: 190px;

        display: flex;

        align-items: center;

        justify-content: flex-end;

        gap: 6px;

        flex-wrap: wrap;
    }

    .daily-actions form {
        margin: 0;

        display: inline-flex;
    }

    .daily-actions .btn {
        white-space: nowrap;

        flex-shrink: 0;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .daily-empty {
        background: #ffffff;

        border-radius: 16px;

        padding: 50px 24px;

        text-align: center;

        color: #64748b;

        box-shadow:
            0 4px 20px rgba(15, 23, 42, 0.06);
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .daily-pagination {
        margin-top: 24px;
    }


    /* =========================================================
       TABLET
       768px - 991px
    ========================================================= */

    @media (max-width: 991.98px) {

        .daily-page-header {
            align-items: flex-start;
        }

        .daily-page-title h3 {
            font-size: 25px;
        }

        .daily-item {

            grid-template-columns:
                125px
                minmax(0, 1fr);

            column-gap: 20px;

            row-gap: 20px;

            align-items: start;

            padding: 24px;
        }

        .daily-date {
            grid-column: 1;
            grid-row: 1;
        }

        .daily-content {
            grid-column: 2;
            grid-row: 1;
        }

        .daily-actions {
            grid-column: 1 / -1;
            grid-row: 2;

            justify-content: flex-end;

            min-width: 0;

            padding-top: 4px;

            border-top: 1px solid #eef0f4;
        }

    }


    /* =========================================================
       MOBILE
       <= 767px
    ========================================================= */

    @media (max-width: 767.98px) {

        .daily-page-header {
            flex-direction: column;

            align-items: stretch;

            gap: 16px;

            margin-bottom: 20px;
        }

        .daily-page-title h3 {
            font-size: 23px;
        }

        .daily-page-title p {
            font-size: 14px;
        }

        .daily-add-button {
            width: 100%;

            text-align: center;

            padding: 11px 16px;
        }


        /* CARD */

        .daily-item {

            display: flex;

            flex-direction: column;

            align-items: stretch;

            gap: 16px;

            padding: 20px;

            border-radius: 14px;
        }


        /* DATE */

        .daily-date {
            width: 100%;
        }

        .daily-date-date {
            font-size: 13px;
        }

        .daily-date-day {
            font-size: 17px;
        }


        /* CONTENT */

        .daily-content {
            width: 100%;
        }

        .daily-content-title {
            font-size: 19px;

            line-height: 1.35;

            margin-bottom: 8px;
        }

        .daily-content-description {
            font-size: 14px;

            line-height: 1.6;
        }


        /* ACTIONS */

        .daily-actions {

            width: 100%;

            min-width: 0;

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 8px;

            justify-content: stretch;

            padding-top: 16px;

            border-top: 1px solid #eef0f4;
        }

        .daily-actions .btn {
            width: 100%;

            min-height: 38px;
        }

        .daily-actions a:first-child {

            grid-column: 1 / -1;
        }

        .daily-actions form {

            width: 100%;
        }

        .daily-actions form .btn {

            width: 100%;
        }

    }


    /* =========================================================
       SMALL MOBILE
       <= 575px
    ========================================================= */

    @media (max-width: 575.98px) {

        .daily-page-title h3 {
            font-size: 21px;
        }

        .daily-page-title p {
            font-size: 14px;
        }

        .daily-item {
            padding: 17px;

            margin-bottom: 14px;
        }

        .daily-content-title {
            font-size: 18px;
        }

        .daily-content-description {
            font-size: 14px;
        }

        .daily-actions {
            grid-template-columns: 1fr 1fr;
        }

    }


    /* =========================================================
       VERY SMALL MOBILE
       <= 380px
    ========================================================= */

    @media (max-width: 380px) {

        .daily-item {
            padding: 15px;
        }

        .daily-content-title {
            font-size: 17px;
        }

        .daily-actions {
            grid-template-columns: 1fr;
        }

        .daily-actions a:first-child {
            grid-column: auto;
        }

    }

</style>


<div class="daily-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="daily-page-header">


        <div class="daily-page-title">

            <h3>
                Progres Harian Tugas Akhir
            </h3>

            <p>
                Dokumentasikan proses pembuatan dashboard setiap hari.
            </p>

        </div>


        <a
            href="<?php echo e(route('daily-progress.create')); ?>"
            class="btn btn-primary daily-add-button"
        >

            <i class="bi bi-plus-lg me-1"></i>

            Tambah Progres

        </a>

    </div>


    <!-- =====================================================
         DAILY PROGRESS LIST
    ====================================================== -->

    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


        <div class="daily-item">


            <!-- =================================================
                 DATE
            ================================================== -->

            <div class="daily-date">

                <div class="daily-date-date">

                    <?php echo e($i->date->format('d M Y')); ?>


                </div>

                <div class="daily-date-day">

                    <?php echo e($i->date->format('l')); ?>


                </div>

            </div>


            <!-- =================================================
                 CONTENT
            ================================================== -->

            <div class="daily-content">

                <h5 class="daily-content-title">

                    <?php echo e($i->short_description); ?>


                </h5>


                <p class="daily-content-description">

                    <?php echo e(Str::limit($i->detailed_description, 220)); ?>


                </p>

            </div>


            <!-- =================================================
                 ACTIONS
            ================================================== -->

            <div class="daily-actions">


                <?php if($i->screenshot_path): ?>

                    <a
                        target="_blank"
                        href="<?php echo e(Storage::url($i->screenshot_path)); ?>"
                        class="btn btn-sm btn-outline-secondary"
                    >

                        <i class="bi bi-image me-1"></i>

                        Lihat Bukti

                    </a>

                <?php endif; ?>


                <a
                    href="<?php echo e(route('daily-progress.edit', $i)); ?>"
                    class="btn btn-sm btn-outline-primary"
                >

                    <i class="bi bi-pencil me-1"></i>

                    Edit

                </a>


                <form
                    method="POST"
                    action="<?php echo e(route('daily-progress.destroy', $i)); ?>"
                >

                    <?php echo csrf_field(); ?>

                    <?php echo method_field('DELETE'); ?>

                    <button
                        type="submit"
                        class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Apakah kamu yakin ingin menghapus progres ini?')"
                    >

                        <i class="bi bi-trash me-1"></i>

                        Hapus

                    </button>

                </form>


            </div>

        </div>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>


        <div class="daily-empty">

            <i
                class="bi bi-journal-text"
                style="font-size: 36px;"
            ></i>

            <div class="mt-3">

                Belum ada progres harian.

            </div>

        </div>


    <?php endif; ?>


    <!-- =====================================================
         PAGINATION
    ====================================================== -->

    <?php if($items->hasPages()): ?>

        <div class="daily-pagination">

            <?php echo e($items->links()); ?>


        </div>

    <?php endif; ?>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\laragon\www\Sistem_Monitoring_Magang\resources\views/daily/index.blade.php ENDPATH**/ ?>