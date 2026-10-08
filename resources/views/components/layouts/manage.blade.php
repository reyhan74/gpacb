<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Panel GPA SMK Canda Bhirawa Pare' }}</title>
    <link rel="icon" type="image/png" href="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}">

    <!-- PRE-RENDER THEME ENGINE (Zero-Flicker) -->
    <script>
        (function() {
            function getPreferredTheme() {
                const saved = localStorage.getItem('gpa-theme') || localStorage.getItem('app-theme') || localStorage.getItem('theme');
                if (saved === 'dark' || saved === 'light') return saved;
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            const theme = getPreferredTheme();
            document.documentElement.setAttribute('data-bs-theme', theme);
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark', 'dark-mode');
                document.documentElement.classList.remove('light-mode');
            } else {
                document.documentElement.classList.remove('dark', 'dark-mode');
                document.documentElement.classList.add('light-mode');
            }
            document.addEventListener('DOMContentLoaded', function() {
                const activeTheme = document.documentElement.getAttribute('data-bs-theme') || theme;
                if (document.body) {
                    if (activeTheme === 'dark') {
                        document.body.classList.add('dark-mode');
                        document.body.classList.remove('light-mode');
                    } else {
                        document.body.classList.remove('dark-mode');
                        document.body.classList.add('light-mode');
                    }
                }
            });
        })();
    </script>

    <!-- FONTS & VENDOR CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- LUCIDE ICONS -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* ==========================================================================
           GLOBAL DESIGN SYSTEM & CSS VARIABLES (GPA Green Theme)
           ========================================================================== */
        :root, [data-bs-theme="light"] {
            --font-primary: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --sidebar-bg: #0d2818;
            --sidebar-border: rgba(255, 255, 255, 0.06);
            --content-bg: #f8fafc;
            --wrapper-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --accent-color: #166534;
            --accent-glow: rgba(22, 101, 52, 0.25);
            --border-color: #e2e8f0;
            --card-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.04);
            --card-hover-shadow: 0 20px 35px -5px rgba(15, 23, 42, 0.08);
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 88px;
            --transition-speed: 0.35s;
            --transition-curve: cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-bs-theme="dark"] {
            --content-bg: #090d16;
            --wrapper-bg: #111827;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.10);
            --card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.3);
            --card-hover-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.5);
        }

        [data-bs-theme="dark"] body,
        [data-bs-theme="dark"] .content,
        [data-bs-theme="dark"] .main-wrapper {
            background-color: #090d16 !important;
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .main-wrapper {
            border-color: #1f2937;
        }

        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .dash-card,
        [data-bs-theme="dark"] .stat-card,
        [data-bs-theme="dark"] .form-card,
        [data-bs-theme="dark"] .modal-content,
        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #111827 !important;
            color: #e5e7eb !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .card-header,
        [data-bs-theme="dark"] .card-footer {
            background-color: #111827 !important;
            color: #e5e7eb;
            border-color: #334155;
        }

        [data-bs-theme="dark"] .text-dark { color: #f8fafc !important; }
        [data-bs-theme="dark"] .text-muted { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .bg-white { background-color: #111827 !important; }
        [data-bs-theme="dark"] .bg-light { background-color: #1f2937 !important; }
        [data-bs-theme="dark"] .border-light { border-color: #334155 !important; }
        [data-bs-theme="dark"] .table { --bs-table-bg: #111827; --bs-table-color: #e5e7eb; --bs-table-border-color: #334155; }
        [data-bs-theme="dark"] .table-light { --bs-table-bg: #1f2937; --bs-table-color: #cbd5e1; }
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select,
        [data-bs-theme="dark"] .input-group-text {
            background-color: #0f172a;
            color: #f8fafc;
            border-color: #334155;
        }
        [data-bs-theme="dark"] .form-control::placeholder { color: #94a3b8; }
        [data-bs-theme="dark"] .btn-light { background-color: #1f2937; color: #e5e7eb; border-color: #475569; }
        [data-bs-theme="dark"] .btn-light:hover { background-color: #334155; color: #fff; }
        [data-bs-theme="dark"] .dropdown-item { color: #e5e7eb; }
        [data-bs-theme="dark"] .dropdown-item:hover { background-color: #1f2937; color: #fff; }
        [data-bs-theme="dark"] .btn-white {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        body {
            font-family: var(--font-primary);
            background: var(--sidebar-bg);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* --- SIDEBAR CONTAINER --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            background: var(--sidebar-bg);
            transition: width var(--transition-speed) var(--transition-curve),
                        transform var(--transition-speed) var(--transition-curve);
            border-right: 1px solid var(--sidebar-border);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* --- CONTENT AREA LAYER --- */
        .content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            transition: margin-left var(--transition-speed) var(--transition-curve);
        }

        .content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Main Wrapper (White/Dark Dynamic Board) */
        .main-wrapper {
            background: var(--content-bg);
            min-height: 100vh;
            border-radius: 36px 0 0 0;
            padding: 28px 36px;
            position: relative;
            z-index: 2;
            box-shadow: -15px 0 35px rgba(0, 0, 0, 0.12);
            transition: background-color 0.3s ease, border-radius 0.3s ease;
            animation: fade-in-up 0.6s var(--transition-curve);
        }

        /* --- MODERN ANIMATIONS & UX UPGRADES --- */
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(12px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes subtle-fade-in {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes scale-up-spring {
            0% { opacity: 0; transform: scale(0.96); }
            60% { opacity: 1; transform: scale(1.01); }
            100% { opacity: 1; transform: scale(1); }
        }

        @keyframes shimmer-sweep {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes badge-glow {
            0%, 100% { opacity: 0.85; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
        }

        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 var(--accent-glow); }
            70% { box-shadow: 0 0 0 8px rgba(0, 0, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 0, 0, 0); }
        }

        .animate-fade-in { animation: subtle-fade-in 0.35s ease-out forwards; }
        .animate-scale-up { animation: scale-up-spring 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-slide-up { animation: fade-in-up 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        /* Card interactive micro-animations */
        .dash-card, .card {
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), border-color 0.3s ease !important;
        }
        .dash-card:hover, .card:hover:not(.no-hover):not(.modal-content) {
            transform: translateY(-4px) !important;
            box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.12) !important;
        }
        [data-bs-theme="dark"] .dash-card:hover, [data-bs-theme="dark"] .card:hover:not(.no-hover):not(.modal-content) {
            box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.6) !important;
        }

        /* Icon shape pulse hover */
        .icon-shape-modern, .icon-shape, .summary-icon-wrapper {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), filter 0.3s ease;
        }
        .dash-card:hover .icon-shape-modern, .card:hover .icon-shape-modern,
        .dash-card:hover .icon-shape, .card:hover .icon-shape {
            transform: scale(1.12) rotate(3deg);
        }

        /* Interactive buttons with tactile press */
        .btn {
            position: relative;
            overflow: hidden;
            transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.2s ease, background-color 0.2s ease, color 0.2s ease !important;
        }
        .btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(22, 101, 52, 0.2);
        }
        .btn:active:not(:disabled) {
            transform: scale(0.96) translateY(0);
        }

        /* Smooth badge hover effects */
        .badge {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .badge:hover {
            transform: translateY(-1px);
        }

        /* Table rows stagger interaction */
        .table-hover tbody tr {
            transition: background-color 0.2s ease, transform 0.2s ease;
        }
        .table-hover tbody tr:hover {
            transform: scale(1.002);
        }
        [data-bs-theme="dark"] .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.04) !important;
        }
        [data-bs-theme="light"] .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.015) !important;
        }

        /* Sidebar link active & hover animation */
        .role-sidebar .nav-item-custom, .sidebar-custom .nav-item-custom {
            transition: all 0.25s cubic-bezier(0.2, 0.8, 0.2, 1) !important;
        }
        .role-sidebar .nav-item-custom:hover, .sidebar-custom .nav-item-custom:hover {
            transform: translateX(4px);
        }

        /* Inputs focus animation */
        .form-control, .form-select {
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease !important;
        }
        .form-control:focus, .form-select:focus {
            transform: translateY(-1px);
        }

        /* Modal pop-in effect */
        .modal.fade .modal-dialog {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
            transform: scale(0.95);
        }
        .modal.show .modal-dialog {
            transform: scale(1);
        }

        /* Respect accessibility preference */
        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
                transform: none !important;
            }
        }

        /* --- RESPONSIVE MOBILE BREAKPOINTS --- */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width) !important;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0 !important;
                background: var(--content-bg);
            }
            .main-wrapper {
                border-radius: 0;
                padding: 20px 16px;
                box-shadow: none;
            }
        }

        /* Overlay Background */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            z-index: 1040;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* --- MODERN CARD COMPONENT STYLES --- */
        .stat-card {
            background: var(--wrapper-bg);
        }

        .icon-shape {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        /* Soft Accent Colors */
        .bg-soft-primary { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
        .bg-soft-success { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .bg-soft-warning { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
        .bg-soft-danger  { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
        .bg-soft-info    { background: rgba(6, 182, 212, 0.12); color: #06b6d4; }

        /* Modern Table Data Grid */
        .table-container {
            background: var(--wrapper-bg);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        .custom-table {
            margin-bottom: 0;
            color: var(--text-main);
        }
        .custom-table thead {
            background-color: rgba(0, 0, 0, 0.02);
        }
        [data-bs-theme="dark"] .custom-table thead {
            background-color: rgba(255, 255, 255, 0.03);
        }
        .custom-table thead th {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            padding: 18px 24px;
        }
        .custom-table tbody td {
            padding: 18px 24px;
            vertical-align: middle;
            color: var(--text-main);
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border-color);
        }

        /* Form Layout */
        .form-card {
            background: var(--wrapper-bg);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }
        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.88rem;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            background-color: var(--wrapper-bg);
            color: var(--text-main);
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px var(--accent-glow);
            background-color: var(--wrapper-bg);
            color: var(--text-main);
        }

        .input-group-text {
            background: rgba(0, 0, 0, 0.03);
            border-color: var(--border-color);
            border-radius: 12px 0 0 12px !important;
            color: var(--text-muted);
        }
        [data-bs-theme="dark"] .input-group-text {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Toast Container */
        .toast-container-custom {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 1090;
        }

        /* --- NAVBAR STYLES --- */
        .navbar-custom-wrapper {
            position: sticky;
            top: 0;
            z-index: 1030;
            padding: 12px 0;
            margin-bottom: 2rem;
            background: var(--content-bg, #f8fafc);
            transition: background-color 0.25s ease, box-shadow 0.25s ease;
        }

        .navbar-custom-wrapper::before {
            content: '';
            position: absolute;
            inset: 0 -36px;
            z-index: -1;
            background: var(--content-bg, #f8fafc);
            border-bottom: 1px solid transparent;
        }

        @media (max-width: 991.98px) {
            .navbar-custom-wrapper::before { inset: 0 -16px; }
        }

        @media (max-width: 575.98px) {
            .navbar-custom-wrapper { padding: 10px 0; margin-bottom: 1.25rem; }
        }

        .btn-nav-action {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--wrapper-bg, #ffffff);
            border: 1px solid var(--border-color, #e2e8f0);
            color: var(--text-main, #1e293b);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            padding: 0;
        }

        .btn-nav-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
            border-color: var(--accent-color, #166534);
            color: var(--accent-color, #166534);
        }

        .btn-nav-action:active {
            transform: translateY(0);
        }

        /* User Profile Pill */
        .nav-user-pill {
            background: var(--wrapper-bg, #ffffff);
            border: 1px solid var(--border-color, #e2e8f0);
            padding: 6px 14px 6px 6px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            user-select: none;
        }

        .nav-user-pill:hover {
            border-color: var(--accent-color, #166534);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .avatar-initial-pill {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: linear-gradient(135deg, #166534 0%, #15803d 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.35);
            flex-shrink: 0;
        }

        [data-bs-theme="dark"] .navbar-custom-wrapper,
        [data-bs-theme="dark"] .navbar-custom-wrapper::before { background: #090d16 !important; }

        /* Modern Floating Dropdown */
        .dropdown-menu-modern {
            background: var(--wrapper-bg, #ffffff) !important;
            border: 1px solid var(--border-color, #e2e8f0) !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.12) !important;
            padding: 10px !important;
            min-width: 230px;
            margin-top: 12px !important;
            animation: dropdownSlideIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-bs-theme="dark"] .dropdown-menu-modern { background: #111827 !important; color: #e5e7eb; }

        @keyframes dropdownSlideIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .dropdown-item-modern {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-main, #334155);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dropdown-item-modern i { width: 18px; height: 18px; opacity: 0.7; transition: opacity 0.2s ease; }
        .dropdown-item-modern:hover { background: rgba(22, 101, 52, 0.08); color: var(--accent-color, #166534); }
        .dropdown-item-modern:hover i { opacity: 1; }
        .dropdown-item-modern.text-danger-modern { color: #ef4444; }
        .dropdown-item-modern.text-danger-modern:hover { background: rgba(239, 68, 68, 0.08); color: #dc2626; }

        /* Sidebar Toggle Icon */
        .sidebar-toggle-icon { transition: transform .25s ease; }
        .sidebar-toggle-button.is-collapsed .sidebar-toggle-icon { transform: rotate(180deg); }
    </style>
</head>
<body>

    <!-- Overlay Background saat Sidebar Mobile Aktif -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Flash Notifications Container -->
    <div class="toast-container-custom">
        @if(session('success'))
            <div class="toast align-items-center text-white bg-success border-0 show shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 14px;">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i data-lucide="check-circle-2" style="width: 20px; height: 20px;"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-white bg-danger border-0 show shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 14px;">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i data-lucide="alert-triangle" style="width: 20px; height: 20px;"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('status'))
            <div class="toast align-items-center text-white bg-info border-0 show shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 14px;">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i data-lucide="info" style="width: 20px; height: 20px;"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- SIDEBAR -->
    <aside class="sidebar sidebar-custom role-sidebar">
        @include('partials.sidebar-role')
    </aside>

    <!-- CONTENT AREA -->
    <div class="content" id="mainContent">
        <div class="main-wrapper">
            <!-- TOPBAR / NAVBAR -->
            <nav class="navbar navbar-expand navbar-light navbar-custom-wrapper">
                <div class="container-fluid p-0">
                    <!-- Sidebar Toggle Button -->
                    <button class="btn-nav-action me-3 sidebar-toggle-button" id="sidebarToggle" type="button" title="Perkecil sidebar" aria-label="Perkecil sidebar" aria-expanded="true">
                        <i data-lucide="panel-left-close" class="sidebar-toggle-icon" style="width: 20px; height: 20px;"></i>
                    </button>

                    <!-- Page Header -->
                    <div class="d-none d-md-flex align-items-center gap-2">
                        <div>
                            <h5 class="m-0 fw-bold" style="letter-spacing: -0.3px; color: var(--text-main);">{{ $title ?? 'Panel GPA' }}</h5>
                            <span class="text-muted" style="font-size: 0.78rem;">SMK Canda Bhirawa Pare</span>
                        </div>
                    </div>

                    <!-- Right Action Menu -->
                    <div class="ms-auto d-flex align-items-center gap-2 me-1">
                        <!-- Quick Theme Switcher -->
                        <button class="btn-nav-action me-1" onclick="window.toggleTheme()" title="Ganti Mode Gelap/Terang">
                            <i data-lucide="sun-moon" style="width: 19px; height: 19px;"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <div class="nav-user-pill" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar-initial-pill">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                                </div>
                                <div class="d-none d-sm-flex flex-column text-start">
                                    <span class="fw-bold text-truncate" style="font-size: 0.88rem; max-width: 140px; color: var(--text-main); line-height: 1.2;">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <span class="text-muted text-capitalize" style="font-size: 0.7rem; font-weight: 500;">{{ Auth::user()->role }}</span>
                                </div>
                                <i data-lucide="chevron-down" style="width: 16px; height: 16px; color: var(--text-muted);"></i>
                            </div>

                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                                <li class="px-3 py-2 d-md-none border-bottom mb-2">
                                    <div class="fw-bold small" style="color: var(--text-main);">{{ Auth::user()->name }}</div>
                                    <div class="text-muted" style="font-size: 0.72rem;">{{ Auth::user()->email }}</div>
                                </li>

                                @if(auth()->user()->isAnggota())
                                    <li>
                                        <a class="dropdown-item-modern" href="{{ route('member.profile') }}">
                                            <i data-lucide="user"></i>
                                            <span>Profil Saya</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item-modern" href="{{ route('member.password.change') }}">
                                            <i data-lucide="key-round"></i>
                                            <span>Ganti Kata Sandi</span>
                                        </a>
                                    </li>
                                @endif

                                <li><hr class="dropdown-divider my-2 opacity-25"></li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item-modern text-danger-modern border-0 bg-transparent w-100 text-start">
                                            <i data-lucide="log-out"></i>
                                            <span>Keluar Sistem</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- MAIN CONTENT SLOT -->
            {{ $slot }}
        </div>
    </div>

    <!-- Vendor Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Lucide Icons Init
        lucide.createIcons();

        // 2. Sidebar Toggle Engine (Desktop & Mobile)
        function toggleAction() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (sidebar) {
                if (window.innerWidth > 991) {
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    const collapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
                    toggleBtn?.classList.toggle('is-collapsed', collapsed);
                    toggleBtn?.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
                    toggleBtn?.setAttribute('title', collapsed ? 'Perbesar sidebar' : 'Perkecil sidebar');
                    toggleBtn?.setAttribute('aria-label', collapsed ? 'Perbesar sidebar' : 'Perkecil sidebar');
                } else {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            }
        }

        // 3. Event Listeners
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');

        if (window.innerWidth > 991 && localStorage.getItem('sidebar-collapsed') === '1') {
            document.querySelector('.sidebar')?.classList.add('collapsed');
            document.getElementById('mainContent')?.classList.add('expanded');
            toggleBtn?.classList.add('is-collapsed');
            toggleBtn?.setAttribute('aria-expanded', 'false');
            toggleBtn?.setAttribute('title', 'Perbesar sidebar');
            toggleBtn?.setAttribute('aria-label', 'Perbesar sidebar');
        }

        if (toggleBtn) toggleBtn.onclick = toggleAction;
        if (overlay) overlay.onclick = toggleAction;

        // 4. Global Theme Switcher
        window.applyTheme = function(newTheme) {
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            document.documentElement.setAttribute('data-theme', newTheme);

            if (newTheme === 'dark') {
                document.documentElement.classList.add('dark', 'dark-mode');
                document.documentElement.classList.remove('light-mode');
                if (document.body) {
                    document.body.classList.add('dark-mode');
                    document.body.classList.remove('light-mode');
                }
            } else {
                document.documentElement.classList.remove('dark', 'dark-mode');
                document.documentElement.classList.add('light-mode');
                if (document.body) {
                    document.body.classList.remove('dark-mode');
                    document.body.classList.add('light-mode');
                }
            }

            localStorage.setItem('gpa-theme', newTheme);
            localStorage.setItem('app-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            }

            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: newTheme } }));
        };

        window.toggleTheme = function() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            window.applyTheme(newTheme);
        };

        window.addEventListener('storage', function(e) {
            if (e.key === 'gpa-theme' || e.key === 'app-theme' || e.key === 'theme') {
                const updatedTheme = e.newValue;
                if (updatedTheme === 'dark' || updatedTheme === 'light') {
                    window.applyTheme(updatedTheme);
                }
            }
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            if (!localStorage.getItem('gpa-theme') && !localStorage.getItem('app-theme') && !localStorage.getItem('theme')) {
                window.applyTheme(e.matches ? 'dark' : 'light');
            }
        });

        // Auto-close Toast after 5 seconds
        setTimeout(() => {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            });
        }, 5000);
    </script>
</body>
</html>
