<!doctype html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Monitoring Magang' }}</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>

        /* =========================================================
           GLOBAL
        ========================================================= */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            width: 100%;
            min-height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;

            background: #f5f7fb;
            color: #172033;

            font-family:
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }


        /* =========================================================
           MAIN LAYOUT
        ========================================================= */

        .main-layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
            align-items: flex-start;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            position: sticky;
            top: 0;

            flex: 0 0 250px;
            width: 250px;
            height: 100vh;
            min-height: 100vh;

            background: #111827;

            padding: 18px 16px;

            z-index: 1040;

            overflow-y: auto;
            overflow-x: hidden;

            align-self: flex-start;

            transition:
                width 0.2s ease,
                flex-basis 0.2s ease,
                transform 0.2s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }


        /* =========================================================
           BRAND
        ========================================================= */

        .brand {
            font-weight: 800;
            color: #ffffff;

            font-size: 18px;

            white-space: nowrap;

            display: flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 28px;
        }

        .brand i {
            font-size: 20px;
            flex-shrink: 0;
        }


        /* =========================================================
           SIDEBAR LINK
        ========================================================= */

        .sidebar a {
            color: #cbd5e1;

            text-decoration: none;

            display: flex;
            align-items: center;

            min-height: 44px;

            padding: 10px 12px;

            border-radius: 10px;

            margin: 4px 0;

            white-space: nowrap;

            transition:
                background 0.15s ease,
                color 0.15s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: #ffffff;
        }

        .sidebar a i {
            width: 22px;
            min-width: 22px;

            text-align: center;

            font-size: 17px;
        }

        .sidebar .label {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-section {
            color: #64748b;

            font-size: 11px;

            font-weight: 600;

            letter-spacing: 0.04em;

            text-transform: uppercase;

            margin-top: 24px;
            margin-bottom: 7px;

            padding-left: 2px;
        }


        /* =========================================================
           CONTENT
        ========================================================= */

        .content {
            flex: 1 1 auto;

            width: auto;
            min-width: 0;
            min-height: 100vh;

            margin-left: 0;

            overflow-x: hidden;

            background: #f5f7fb;
        }


        /* =========================================================
           TOP NAVBAR
        ========================================================= */

        .navbar-top {
            height: 70px;

            background: #ffffff;

            border-bottom: 1px solid #e5e7eb;

            padding-left: 24px;
            padding-right: 24px;

            position: sticky;
            top: 0;

            z-index: 1020;

            display: flex;
            align-items: center;
        }

        .navbar-title {
            font-size: 16px;

            font-weight: 700;

            color: #172033;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .navbar-user {
            display: flex;

            align-items: center;

            gap: 12px;

            min-width: 0;
        }

        .navbar-user-name {
            color: #64748b;

            font-size: 14px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            max-width: 280px;
        }


        /* =========================================================
           MAIN PAGE WRAPPER
        ========================================================= */

        .page-wrapper {
            width: 100%;
            padding: 24px;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .card {
            border: 0;

            border-radius: 16px;

            box-shadow:
                0 4px 20px rgba(15, 23, 42, 0.06);

            overflow: hidden;
        }


        /* =========================================================
           STAT
        ========================================================= */

        .stat {
            font-size: 28px;

            font-weight: 800;

            line-height: 1.2;
        }


        /* =========================================================
           PROGRESS
        ========================================================= */

        .progress {
            height: 9px;

            border-radius: 20px;
        }


        /* =========================================================
           IMAGE / THUMBNAIL
        ========================================================= */

        .thumb {
            width: 100%;

            height: 150px;

            object-fit: cover;

            border-radius: 12px;

            display: block;
        }


        /* =========================================================
           BUTTON
        ========================================================= */

        .btn {
            white-space: nowrap;
        }


        /* =========================================================
           TABLE
        ========================================================= */

        .table-responsive {
            width: 100%;

            overflow-x: auto;

            -webkit-overflow-scrolling: touch;
        }

        table {
            min-width: 600px;
        }


        /* =========================================================
           LONG TEXT
        ========================================================= */

        .text-break,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            overflow-wrap: anywhere;
            word-break: normal;
        }


        /* =========================================================
           AUTH
        ========================================================= */

        .auth-bg {
            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #2563eb
                );
        }


        /* =========================================================
           TOAST
        ========================================================= */

        .toast-container {
            z-index: 9999;
        }

        .toast {
            max-width: min(420px, calc(100vw - 32px));
        }


        /* =========================================================
           MOBILE MENU BUTTON
        ========================================================= */

        .mobile-menu-btn {
            display: none;

            border: 0;

            background: transparent;

            font-size: 22px;

            color: #172033;

            padding: 4px 8px;

            border-radius: 8px;
        }

        .mobile-menu-btn:hover {
            background: #f1f5f9;
        }


        /* =========================================================
           SIDEBAR OVERLAY
        ========================================================= */

        .sidebar-overlay {
            display: none;

            position: fixed;

            inset: 0;

            background: rgba(15, 23, 42, 0.45);

            z-index: 1030;
        }


        /* =========================================================
           DAILY PROGRESS SUPPORT
        ========================================================= */

        .daily-card-row {
            min-width: 0;
        }

        .daily-date,
        .daily-description,
        .daily-actions {
            min-width: 0;
        }

        .daily-description {
            overflow-wrap: anywhere;
        }

        .daily-actions {
            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 6px;

            flex-wrap: wrap;
        }


        /* =========================================================
           DOCUMENTATION SUPPORT
        ========================================================= */

        .documentation-grid {
            width: 100%;
        }

        .documentation-grid .card {
            height: 100%;
        }

        .documentation-grid img {
            display: block;
            width: 100%;
        }


        /* =========================================================
           DESKTOP LARGE
        ========================================================= */

        @media (min-width: 1200px) {

            .page-wrapper {
                padding: 28px;
            }

        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 991.98px) {

            .sidebar {
                flex: 0 0 76px;
                width: 76px;

                padding-left: 12px;
                padding-right: 12px;
            }

            .sidebar .brand {
                justify-content: center;

                margin-bottom: 28px;
            }

            .sidebar .brand span,
            .sidebar .label,
            .sidebar .sidebar-section {
                display: none;
            }

            .sidebar a {
                justify-content: center;

                padding: 11px 8px;
            }

            .sidebar a i {
                margin: 0;

                width: 24px;
            }

            .content {
                flex: 1 1 auto;

                width: auto;

                margin-left: 0;

                min-width: 0;
            }

            .navbar-top {
                padding-left: 18px;
                padding-right: 18px;
            }

            .page-wrapper {
                padding: 20px;
            }

            .navbar-user-name {
                max-width: 180px;
            }

        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 767.98px) {

            .main-layout {
                display: block;
            }

            .sidebar {
                position: fixed;

                top: 0;
                left: 0;

                width: 250px;
                height: 100vh;
                min-height: 100vh;

                flex: none;

                transform: translateX(-100%);

                padding: 18px 16px;

                z-index: 1050;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar .brand {
                justify-content: flex-start;

                margin-bottom: 28px;
            }

            .sidebar .brand span,
            .sidebar .label,
            .sidebar .sidebar-section {
                display: block;
            }

            .sidebar a {
                justify-content: flex-start;

                padding: 10px 12px;
            }

            .sidebar a i {
                margin-right: 0;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .content {
                width: 100%;

                margin-left: 0;

                min-height: 100vh;
            }

            .mobile-menu-btn {
                display: inline-flex;

                align-items: center;

                justify-content: center;
            }

            .navbar-top {
                height: 62px;

                padding-left: 12px;
                padding-right: 12px;

                gap: 8px;
            }

            .navbar-title {
                font-size: 15px;

                flex: 1;

                min-width: 0;
            }

            .navbar-user {
                gap: 6px;
            }

            .navbar-user-name {
                display: none;
            }

            .navbar-user .btn {
                font-size: 13px;

                padding: 6px 10px;
            }

            .page-wrapper {
                padding: 16px;
            }

            .card {
                border-radius: 14px;
            }

            .stat {
                font-size: 24px;
            }

            .thumb {
                height: 180px;
            }


            /* Daily Progress */

            .daily-card-row {
                display: flex;

                flex-direction: column;

                gap: 16px;
            }

            .daily-date,
            .daily-description,
            .daily-actions {
                width: 100%;

                max-width: 100%;

                flex: 0 0 100%;
            }

            .daily-date {
                text-align: left;
            }

            .daily-actions {
                justify-content: flex-start;

                padding-top: 4px;
            }

            .daily-actions .btn {
                flex: 0 0 auto;
            }


            /* Button header */

            .page-header-responsive {
                flex-direction: column !important;

                align-items: stretch !important;

                gap: 14px;
            }

            .page-header-responsive .btn {
                width: 100%;
            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 575.98px) {

            .page-wrapper {
                padding: 12px;
            }

            .navbar-top {
                padding-left: 8px;
                padding-right: 8px;
            }

            .navbar-title {
                font-size: 14px;
            }

            .mobile-menu-btn {
                font-size: 20px;

                padding: 3px 6px;
            }

            .navbar-user .btn {
                font-size: 12px;

                padding: 5px 8px;
            }

            .card-body {
                padding: 16px !important;
            }

            .btn {
                font-size: 13px;
            }

            .daily-actions {
                display: grid;

                grid-template-columns: 1fr 1fr;

                width: 100%;
            }

            .daily-actions .btn:first-child {
                grid-column: 1 / -1;
            }

            .daily-actions .btn {
                width: 100%;
            }

            .thumb {
                height: 160px;
            }

            .toast {
                width: calc(100vw - 24px);

                max-width: calc(100vw - 24px);
            }

        }


        /* =========================================================
           VERY SMALL SCREEN
        ========================================================= */

        @media (max-width: 380px) {

            .page-wrapper {
                padding: 10px;
            }

            .navbar-top {
                height: 58px;
            }

            .navbar-user .btn {
                padding: 5px 7px;
            }

            .card-body {
                padding: 14px !important;
            }

        }

    </style>

</head>


<body>


    <!-- =========================================================
         SIDEBAR OVERLAY
    ========================================================== -->

    <div
        class="sidebar-overlay"
        id="sidebarOverlay">
    </div>


    <!-- =========================================================
         MAIN WRAPPER
    ========================================================== -->

    <div class="main-layout">


        <!-- =====================================================
             SIDEBAR
        ====================================================== -->

        <aside
            class="sidebar"
            id="mainSidebar">


            <!-- BRAND -->

            <div class="brand">

                <i class="bi bi-activity"></i>

                <span>
                    Monitoring Magang
                </span>

            </div>


            <!-- DASHBOARD -->

            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >

                <i class="bi bi-grid"></i>

                <span class="label ms-2">
                    Dashboard
                </span>

            </a>


            <!-- =================================================
                 MAGANG
            ================================================== -->

            <div class="sidebar-section label">
                Magang
            </div>


            <a
                href="{{ route('weekly-progress.index') }}"
                class="{{ request()->routeIs('weekly-progress.*') ? 'active' : '' }}"
            >

                <i class="bi bi-calendar-week"></i>

                <span class="label ms-2">
                    Progres Mingguan
                </span>

            </a>


            <a
                href="{{ route('documentation.index') }}"
                class="{{ request()->routeIs('documentation.*') ? 'active' : '' }}"
            >

                <i class="bi bi-images"></i>

                <span class="label ms-2">
                    Dokumentasi
                </span>

            </a>


            <!-- =================================================
                 LAPORAN
            ================================================== -->

            <div class="sidebar-section label">
                Laporan
            </div>


            <a
                href="{{ route('report-progress.index') }}"
                class="{{ request()->routeIs('report-progress.*') ? 'active' : '' }}"
            >

                <i class="bi bi-file-earmark-text"></i>

                <span class="label ms-2">
                    Progres Bab
                </span>

            </a>


            <a
                href="{{ route('supporting-documents.index') }}"
                class="{{ request()->routeIs('supporting-documents.*') ? 'active' : '' }}"
            >

                <i class="bi bi-folder-check"></i>

                <span class="label ms-2">
                    Dokumen Sidang
                </span>

            </a>


            <!-- =================================================
                 TUGAS AKHIR
            ================================================== -->

            <div class="sidebar-section label">
                Tugas Akhir
            </div>


            <a
                href="{{ route('daily-progress.index') }}"
                class="{{ request()->routeIs('daily-progress.*') ? 'active' : '' }}"
            >

                <i class="bi bi-code-square"></i>

                <span class="label ms-2">
                    Progres Harian
                </span>

            </a>


        </aside>


        <!-- =====================================================
             MAIN CONTENT
        ====================================================== -->

        <main class="content">


            <!-- =================================================
                 TOP NAVBAR
            ================================================== -->

            <nav class="navbar-top">


                <!-- MOBILE MENU -->

                <button
                    type="button"
                    class="mobile-menu-btn me-2"
                    id="mobileMenuButton"
                    aria-label="Buka menu"
                >

                    <i class="bi bi-list"></i>

                </button>


                <!-- PAGE TITLE -->

                <div class="navbar-title">

                    {{ $pageTitle ?? 'Dashboard' }}

                </div>


                <!-- USER -->

                <div class="navbar-user ms-auto">

                    <span class="navbar-user-name">

                        {{ auth()->user()->name }}

                    </span>


                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="m-0"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-sm btn-outline-danger"
                        >
                            Logout
                        </button>

                    </form>

                </div>


            </nav>


            <!-- =================================================
                 PAGE CONTENT
            ================================================== -->

            <div class="page-wrapper">


                <!-- =================================================
                     NORMAL SUCCESS ALERT
                ================================================== -->

                @if(session('success'))

                    <div
                        class="alert alert-success alert-dismissible fade show"
                        role="alert"
                    >

                        <i class="bi bi-check-circle-fill me-2"></i>

                        {{ session('success') }}

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>

                    </div>

                @endif


                <!-- =================================================
                     VALIDATION ERROR
                ================================================== -->

                @if($errors->any())

                    <div
                        class="alert alert-danger"
                        role="alert"
                    >

                        <strong>
                            Terjadi kesalahan:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <!-- =================================================
                     CONTENT DARI HALAMAN
                ================================================== -->

                @yield('content')


            </div>


        </main>


    </div>


    <!-- =========================================================
         TOAST NOTIFICATION
    ========================================================== -->

    <div
        class="toast-container position-fixed top-0 end-0 p-3"
        style="z-index: 9999;"
    >


        <!-- SUCCESS -->

        @if(session('toast_success'))

            <div
                class="toast align-items-center text-bg-success border-0"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                data-bs-delay="3000"
            >

                <div class="d-flex">

                    <div class="toast-body">

                        <i class="bi bi-check-circle-fill me-2"></i>

                        {{ session('toast_success') }}

                    </div>


                    <button
                        type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"
                        aria-label="Close"
                    ></button>

                </div>

            </div>

        @endif


        <!-- ERROR -->

        @if(session('error'))

            <div
                class="toast align-items-center text-bg-danger border-0"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                data-bs-delay="3000"
            >

                <div class="d-flex">

                    <div class="toast-body">

                        <i class="bi bi-x-circle-fill me-2"></i>

                        {{ session('error') }}

                    </div>


                    <button
                        type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"
                        aria-label="Close"
                    ></button>

                </div>

            </div>

        @endif


        <!-- WARNING -->

        @if(session('warning'))

            <div
                class="toast align-items-center text-bg-warning border-0"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                data-bs-delay="3000"
            >

                <div class="d-flex">

                    <div class="toast-body text-dark">

                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        {{ session('warning') }}

                    </div>


                    <button
                        type="button"
                        class="btn-close me-2 m-auto"
                        data-bs-dismiss="toast"
                        aria-label="Close"
                    ></button>

                </div>

            </div>

        @endif


        <!-- INFO -->

        @if(session('info'))

            <div
                class="toast align-items-center text-bg-info border-0"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                data-bs-delay="3000"
            >

                <div class="d-flex">

                    <div class="toast-body">

                        <i class="bi bi-info-circle-fill me-2"></i>

                        {{ session('info') }}

                    </div>


                    <button
                        type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"
                        aria-label="Close"
                    ></button>

                </div>

            </div>

        @endif


        <!-- VALIDATION ERROR TOAST -->

        @if(session('toast_validation'))

            <div
                class="toast align-items-center text-bg-danger border-0"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                data-bs-delay="4000"
            >

                <div class="d-flex">

                    <div class="toast-body">

                        <i class="bi bi-exclamation-circle-fill me-2"></i>

                        <strong>
                            {{ session('toast_validation') }}
                        </strong>

                    </div>


                    <button
                        type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"
                        aria-label="Close"
                    ></button>

                </div>

            </div>

        @endif


    </div>


    <!-- =========================================================
         BOOTSTRAP JS
    ========================================================== -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    <!-- =========================================================
         MOBILE SIDEBAR SCRIPT
    ========================================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const sidebar =
                document.getElementById('mainSidebar');

            const menuButton =
                document.getElementById('mobileMenuButton');

            const overlay =
                document.getElementById('sidebarOverlay');


            function openSidebar() {

                if (!sidebar) return;

                sidebar.classList.add('mobile-open');

                if (overlay) {
                    overlay.classList.add('show');
                }

                document.body.style.overflow = 'hidden';

            }


            function closeSidebar() {

                if (!sidebar) return;

                sidebar.classList.remove('mobile-open');

                if (overlay) {
                    overlay.classList.remove('show');
                }

                document.body.style.overflow = '';

            }


            /* =====================================================
               MOBILE MENU BUTTON
            ====================================================== */

            if (menuButton) {

                menuButton.addEventListener(
                    'click',
                    function () {

                        if (
                            sidebar &&
                            sidebar.classList.contains('mobile-open')
                        ) {

                            closeSidebar();

                        } else {

                            openSidebar();

                        }

                    }
                );

            }


            /* =====================================================
               OVERLAY
            ====================================================== */

            if (overlay) {

                overlay.addEventListener(
                    'click',
                    function () {

                        closeSidebar();

                    }
                );

            }


            /* =====================================================
               CLOSE SIDEBAR AFTER CLICK MENU
            ====================================================== */

            if (sidebar) {

                const sidebarLinks =
                    sidebar.querySelectorAll('a');

                sidebarLinks.forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (
                                window.innerWidth <= 767
                            ) {

                                closeSidebar();

                            }

                        }
                    );

                });

            }


            /* =====================================================
               RESET SIDEBAR WHEN SCREEN GETS LARGER
            ====================================================== */

            window.addEventListener(
                'resize',
                function () {

                    if (
                        window.innerWidth > 767
                    ) {

                        closeSidebar();

                    }

                }
            );


            /* =====================================================
               TOAST NOTIFICATION
            ====================================================== */

            const toastElements =
                document.querySelectorAll('.toast');


            toastElements.forEach(function (toastElement) {

                const delay =
                    parseInt(
                        toastElement.dataset.bsDelay || 3000,
                        10
                    );


                const toast =
                    new bootstrap.Toast(
                        toastElement,
                        {
                            delay: delay
                        }
                    );


                toast.show();

            });

        });

    </script>


    <!-- =========================================================
         PAGE-SPECIFIC SCRIPTS
    ========================================================== -->

    @yield('scripts')

    @stack('scripts')


</body>

</html>