<?php $user = AuthHelper::user(); ?>
<div class="govt-header-wrapper">
    <!-- MAIN TOP BAR -->
    <header class="govt-header-main">
        <div class="d-flex align-items-center">
            <button id="sidebarToggle" class="btn text-white me-3 d-lg-none fs-5 p-0">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= BASE_URL ?>/dashboard" class="govt-brand">
                <!-- SVG Emblem Logo Pemprov Kalsel Benchmark -->
                <div class="govt-emblem-logo">
                    <svg viewBox="0 0 100 100" width="30" height="30">
                        <polygon points="50,5 90,25 90,75 50,95 10,75 10,25" fill="#eab308" stroke="#15803d" stroke-width="4"/>
                        <rect x="25" y="30" width="50" height="40" rx="5" fill="#166534" />
                        <path d="M 50 15 L 60 40 L 40 40 Z" fill="#dc2626"/>
                        <circle cx="50" cy="50" r="12" fill="#ffffff" />
                        <path d="M 50 42 L 54 50 L 46 50 Z" fill="#eab308"/>
                    </svg>
                </div>
                <span class="govt-app-title">PELAPORAN USAHA KETENAGALISTRIKAN KALIMANTAN SELATAN</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- Notification Bell Icon -->
            <div class="dropdown">
                <button class="btn text-white position-relative p-1 border-0" type="button" data-bs-toggle="dropdown" aria-label="Notifikasi">
                    <i class="far fa-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">Notifikasi</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" style="width: 320px;">
                    <li class="dropdown-header fw-bold text-uppercase fs-8 text-muted border-bottom py-2">Notifikasi Sistem</li>
                    <li>
                        <a class="dropdown-item py-2 border-bottom" href="#">
                            <div class="fw-semibold text-dark fs-7">Periode Pelaporan 2026 Dibuka</div>
                            <div class="text-muted fs-8">Silakan melengkapi laporan tahunan usaha Anda.</div>
                        </a>
                    </li>
                    <li class="text-center py-2"><a href="#" class="fs-8 text-primary fw-semibold text-decoration-none">Lihat Semua Notifikasi</a></li>
                </ul>
            </div>

            <!-- User Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="header-user-profile dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="d-none d-sm-block">
                        <div class="header-user-name"><?= e($user['full_name'] ?? 'Administrator') ?></div>
                        <div class="header-user-role"><?= e($user['role_name'] ?? 'ADMIN') ?></div>
                    </div>
                    <div class="header-user-avatar">
                        <svg viewBox="0 0 100 100" width="28" height="28">
                            <polygon points="50,5 90,25 90,75 50,95 10,75 10,25" fill="#eab308" stroke="#15803d" stroke-width="4"/>
                            <rect x="25" y="30" width="50" height="40" rx="5" fill="#166534" />
                            <path d="M 50 15 L 60 40 L 40 40 Z" fill="#dc2626"/>
                        </svg>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                    <li class="px-3 py-2 bg-light border-bottom">
                        <div class="fw-bold text-dark"><?= e($user['full_name'] ?? '') ?></div>
                        <div class="fs-8 text-muted"><?= e($user['email'] ?? '') ?></div>
                    </li>
                    <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>/change-password"><i class="fas fa-key text-muted me-2"></i>Ubah Password</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item py-2 text-danger fw-semibold" href="<?= BASE_URL ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Keluar (Logout)</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- SUB HEADER BAR -->
    <div class="govt-header-sub">
        DINAS ENERGI DAN SUMBER DAYA MINERAL PROVINSI KALIMANTAN SELATAN
    </div>
</div>
