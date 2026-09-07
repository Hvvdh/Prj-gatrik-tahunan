
<?php $user = AuthHelper::user(); ?>
<div class="govt-header-wrapper">
    <header class="govt-header-main">
        <div class="d-flex align-items-center">
            <button id="sidebarToggle" class="btn text-secondary me-3 d-lg-none fs-5 p-2" style="border-radius: 8px;">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= BASE_URL ?>/dashboard" class="govt-brand">
                <span class="govt-app-title">PELAPORAN USAHA KETENAGALISTRIKAN KALIMANTAN SELATAN</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- Notification -->
            <div class="dropdown">
                <button class="header-notification-btn" type="button" data-bs-toggle="dropdown" aria-label="Notifikasi">
                    <i class="far fa-bell"></i>
                    <span class="badge-dot"></span>
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

            <!-- User Profile -->
            <div class="dropdown">
                <a href="#" class="header-user-profile dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
                    <div class="d-none d-sm-block text-end">
                        <div class="header-user-name"><?= e($user['full_name'] ?? 'Administrator') ?></div>
                        <div class="header-user-role"><?= e($user['role_name'] ?? 'ADMIN') ?></div>
                    </div>
                    <div class="header-user-avatar">
                        <i class="fas fa-user text-white"></i>
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
</div>