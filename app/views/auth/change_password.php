<?php
$pageTitle = "Ubah Password - Wasdal Gatrik Kalsel";
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/navbar.php';
?>

<div class="main-wrapper" style="margin-left: 0;">
    <div class="container" style="max-width: 540px; margin-top: 3rem;">
        <div class="card card-custom shadow border-0 overflow-hidden">
            <div class="card-header bg-warning text-dark p-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.25rem;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Perbarui Password Default</h5>
                        <div class="fs-8 text-dark opacity-75">Demi keamanan sistem, silakan ubah password default Anda.</div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <?php if ($msg = get_flash('danger')): ?>
                    <div class="alert alert-danger alert-dismissible fade show fs-8 py-2 mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i> <?= $msg ?>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($msg = get_flash('warning')): ?>
                    <div class="alert alert-warning alert-dismissible fade show fs-8 py-2 mb-4" role="alert">
                        <i class="fas fa-info-circle me-1"></i> <?= $msg ?>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/auth/update-password" method="POST">
                    <input type="hidden" name="_csrf_token" value="<?= generate_csrf_token() ?>">

                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold fs-7 text-dark">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="new_password" name="new_password" placeholder="Minimal 6 karakter" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label fw-semibold fs-7 text-dark">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-double text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="confirm_password" name="confirm_password" placeholder="Ulangi password baru" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Password Baru
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
