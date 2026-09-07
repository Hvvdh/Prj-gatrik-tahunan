<?php
/**
 * Login View - Premium Split-Screen Design
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Ketenagalistrikan Kalsel</title>
    <meta name="description" content="Sistem Informasi dan Monitoring Usaha Ketenagalistrikan Dinas ESDM Provinsi Kalimantan Selatan">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0f4f8;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }

        /* ========== LEFT PANEL - BRANDING ========== */
        .login-brand-panel {
            flex: 0 0 52%;
            background: linear-gradient(135deg, #0c1d4a 0%, #163e82 40%, #1d4ed8 75%, #2563eb 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            overflow: hidden;
        }

        /* Animated mesh gradient overlay */
        .login-brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(59,130,246,0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(139,92,246,0.2) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(14,165,233,0.25) 0%, transparent 50%);
            animation: meshShift 8s ease-in-out infinite alternate;
        }

        @keyframes meshShift {
            0% { opacity: 0.7; transform: scale(1); }
            100% { opacity: 1; transform: scale(1.05); }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(720deg); opacity: 0; }
        }

        /* Grid lines decorative */
        .grid-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 480px;
        }

        .brand-emblem {
            width: 88px;
            height: 88px;
            border-radius: 24px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: emblemPulse 3s ease-in-out infinite;
        }

        @keyframes emblemPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.3); }
            50% { box-shadow: 0 0 0 16px rgba(59,130,246,0); }
        }

        .brand-emblem i {
            font-size: 2.2rem;
            color: #fbbf24;
            filter: drop-shadow(0 2px 8px rgba(251,191,36,0.4));
        }

        .brand-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.3;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.7);
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
        }

        /* Feature highlights */
        .feature-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .feature-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.5rem 1rem;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50px;
            color: rgba(255,255,255,0.9);
            font-size: 0.78rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .feature-pill:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        .feature-pill i {
            font-size: 0.72rem;
            color: #60a5fa;
        }

        /* ========== RIGHT PANEL - FORM ========== */
        .login-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #ffffff;
            position: relative;
        }

        .login-form-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #2563eb, #7c3aed, #06b6d4);
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            animation: fadeSlideUp 0.6s ease-out;
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-header .greeting {
            font-size: 0.82rem;
            font-weight: 600;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0.5rem;
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .form-header .desc {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.5;
        }

        /* Alert styling */
        .login-alert {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeSlideUp 0.4s ease-out;
        }

        .login-alert.alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .login-alert.alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .login-alert.alert-warning {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* Form controls */
        .form-floating-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .form-floating-custom label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            transition: color 0.2s ease;
            z-index: 2;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.75rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #1e293b;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.25s ease;
            outline: none;
        }

        .input-wrapper input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .input-wrapper input:focus {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }

        .input-wrapper input:focus ~ .input-icon {
            color: #3b82f6;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 4px;
            z-index: 2;
            transition: color 0.2s ease;
        }

        .toggle-password:hover { color: #475569; }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            font-size: 0.92rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-login:hover::before { opacity: 1; }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(37,99,235,0.35); }
        .btn-login:active { transform: translateY(0); }
        .btn-login span, .btn-login i { position: relative; z-index: 1; }

        /* Divider */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.75rem 0;
            color: #cbd5e1;
            font-size: 0.78rem;
            font-weight: 500;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* Registration link */
        .register-link {
            text-align: center;
        }

        .register-link span {
            font-size: 0.84rem;
            color: #64748b;
        }

        .register-link a {
            font-size: 0.84rem;
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .register-link a:hover { color: #1d4ed8; text-decoration: underline; }

        /* Footer */
        .login-footer {
            position: absolute;
            bottom: 1.5rem;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.72rem;
            color: #94a3b8;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991.98px) {
            body { flex-direction: column; overflow-y: auto; }
            .login-brand-panel {
                flex: 0 0 auto;
                padding: 2.5rem 2rem;
                min-height: 320px;
            }
            .login-form-panel {
                padding: 2rem 1.5rem;
            }
            .login-form-panel::before { display: none; }
            .brand-title { font-size: 1.3rem; }
        }

        @media (max-width: 575.98px) {
            .login-brand-panel { padding: 2rem 1.25rem; min-height: 260px; }
            .brand-emblem { width: 64px; height: 64px; border-radius: 16px; margin-bottom: 1.25rem; }
            .brand-emblem i { font-size: 1.5rem; }
            .brand-title { font-size: 1.1rem; }
            .feature-pills { display: none; }
            .form-header h1 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

    <!-- LEFT BRANDING PANEL -->
    <div class="login-brand-panel">
        <div class="grid-lines"></div>

        <!-- Floating particles -->
        <div class="particle" style="width:6px;height:6px;left:10%;animation-duration:12s;animation-delay:0s;"></div>
        <div class="particle" style="width:4px;height:4px;left:25%;animation-duration:16s;animation-delay:2s;"></div>
        <div class="particle" style="width:8px;height:8px;left:45%;animation-duration:10s;animation-delay:4s;"></div>
        <div class="particle" style="width:5px;height:5px;left:65%;animation-duration:14s;animation-delay:1s;"></div>
        <div class="particle" style="width:3px;height:3px;left:80%;animation-duration:18s;animation-delay:3s;"></div>
        <div class="particle" style="width:7px;height:7px;left:35%;animation-duration:11s;animation-delay:5s;"></div>
        <div class="particle" style="width:5px;height:5px;left:90%;animation-duration:15s;animation-delay:6s;"></div>

        <div class="brand-content">
            <div class="brand-emblem">
                <i class="fas fa-bolt"></i>
            </div>
            <h2 class="brand-title"><?= APP_SYSTEM_NAME ?></h2>
            <div class="brand-subtitle"><?= APP_AGENCY_NAME ?></div>

            <div class="feature-pills">
                <div class="feature-pill"><i class="fas fa-shield-halved"></i> Aman & Terenkripsi</div>
                <div class="feature-pill"><i class="fas fa-chart-pie"></i> Dashboard Real-Time</div>
                <div class="feature-pill"><i class="fas fa-file-circle-check"></i> Pelaporan Digital</div>
                <div class="feature-pill"><i class="fas fa-clock"></i> Monitoring 24/7</div>
            </div>
        </div>
    </div>

    <!-- RIGHT FORM PANEL -->
    <div class="login-form-panel">
        <div class="form-container">
            <div class="form-header">
                <div class="greeting">Selamat Datang</div>
                <h1>Masuk ke Sistem</h1>
                <p class="desc">Silakan masukkan kredensial Anda untuk mengakses panel pelaporan ketenagalistrikan.</p>
            </div>

            <?php if ($msg = get_flash('danger')): ?>
                <div class="login-alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= $msg ?>
                </div>
            <?php endif; ?>

            <?php if ($msg = get_flash('success')): ?>
                <div class="login-alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= $msg ?>
                </div>
            <?php endif; ?>

            <?php if ($msg = get_flash('warning')): ?>
                <div class="login-alert alert-warning">
                    <i class="fas fa-info-circle"></i> <?= $msg ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/auth/login" method="POST" autocomplete="off">
                <input type="hidden" name="_csrf_token" value="<?= generate_csrf_token() ?>">

                <div class="form-floating-custom">
                    <label for="username">Username Akun</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required autofocus>
                    </div>
                </div>

                <div class="form-floating-custom">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                        <button type="button" class="toggle-password" onclick="togglePass()" aria-label="Tampilkan password">
                            <i class="far fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    <span>Masuk ke Sistem</span>
                </button>
            </form>

            <div class="form-divider">atau</div>

            <div class="register-link">
                <span>Belum memiliki akun? </span>
                <a href="#">Registrasi Perusahaan Baru</a>
            </div>
        </div>

        <div class="login-footer">
            &copy; <?= date('Y') ?> <?= APP_AGENCY_NAME ?> &bull; v<?= APP_VERSION ?>
        </div>
    </div>

<script>
function togglePass() {
    const pwd = document.getElementById('password');
    const eye = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pwd.type = 'password';
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
