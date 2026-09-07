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

    /* LEFT PANEL */
    .login-brand-panel {
        flex: 0 0 50%;
        background: linear-gradient(135deg, #0c1d4a 0%, #163e82 40%, #1d4ed8 100%);
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        overflow: hidden;
    }

    .login-brand-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 20% 50%, rgba(59,130,246,0.2) 0%, transparent 50%),
                    radial-gradient(ellipse at 80% 20%, rgba(139,92,246,0.15) 0%, transparent 50%);
    }

    .grid-lines {
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .brand-content { position: relative; z-index: 2; text-align: center; max-width: 480px; }

    .brand-emblem {
        width: 80px; height: 80px; border-radius: 20px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 2rem;
    }
    .brand-emblem i { font-size: 2rem; color: #fbbf24; }

    .brand-title { font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1.3; margin-bottom: 0.75rem; }
    .brand-subtitle { font-size: 0.85rem; color: rgba(255,255,255,0.7); font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 2rem; }

    .feature-pills { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
    .feature-pill {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 0.5rem 1rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 50px; color: rgba(255,255,255,0.9);
        font-size: 0.78rem; font-weight: 500;
    }
    .feature-pill i { font-size: 0.72rem; color: #60a5fa; }

    /* RIGHT PANEL */
    .login-form-panel {
        flex: 1; display: flex; align-items: center; justify-content: center;
        padding: 3rem; background: #fff; position: relative;
    }
    .login-form-panel::before {
        content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%;
        background: linear-gradient(180deg, #2563eb, #7c3aed);
    }

    .form-container { width: 100%; max-width: 400px; animation: fadeSlideUp 0.5s ease-out; }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-header { margin-bottom: 2rem; }
    .form-header .greeting { font-size: 0.8rem; font-weight: 600; color: #2563eb; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.5rem; }
    .form-header h1 { font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; margin-bottom: 0.5rem; }
    .form-header .desc { font-size: 0.88rem; color: #64748b; line-height: 1.5; }

    /* Alerts */
    .login-alert { padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.82rem; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
    .login-alert.alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .login-alert.alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .login-alert.alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }

    /* Form */
    .form-floating-custom { position: relative; margin-bottom: 1.25rem; }
    .form-floating-custom label { font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; display: block; }
    .input-wrapper { position: relative; }
    .input-wrapper .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem; z-index: 2; }
    .input-wrapper input { width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; font-size: 0.9rem; font-weight: 500; color: #1e293b; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; transition: all 0.25s ease; outline: none; }
    .input-wrapper input::placeholder { color: #94a3b8; font-weight: 400; }
    .input-wrapper input:focus { background: #fff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
    .toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 0.9rem; padding: 4px; z-index: 2; }

    .btn-login {
        width: 100%; padding: 0.85rem; font-size: 0.92rem; font-weight: 700; color: #fff;
        background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; border-radius: 12px;
        cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;
    }
    .btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(37,99,235,0.35); }

    .form-divider { display: flex; align-items: center; gap: 1rem; margin: 1.75rem 0; color: #cbd5e1; font-size: 0.78rem; font-weight: 500; }
    .form-divider::before, .form-divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }

    .register-link { text-align: center; }
    .register-link span { font-size: 0.84rem; color: #64748b; }
    .register-link a { font-size: 0.84rem; color: #2563eb; font-weight: 600; text-decoration: none; }
    .register-link a:hover { text-decoration: underline; }

    .login-footer { position: absolute; bottom: 1.5rem; left: 0; right: 0; text-align: center; font-size: 0.72rem; color: #94a3b8; }

    /* Responsive */
    @media (max-width: 991.98px) {
        body { flex-direction: column; overflow-y: auto; }
        .login-brand-panel { flex: 0 0 auto; padding: 2.5rem 2rem; min-height: 280px; }
        .login-form-panel { padding: 2rem 1.5rem; }
        .login-form-panel::before { display: none; }
        .brand-title { font-size: 1.3rem; }
    }
    @media (max-width: 575.98px) {
        .login-brand-panel { padding: 2rem 1.25rem; min-height: 240px; }
        .brand-emblem { width: 64px; height: 64px; margin-bottom: 1.25rem; }
        .brand-title { font-size: 1.1rem; }
        .feature-pills { display: none; }
        .form-header h1 { font-size: 1.4rem; }
    }
</style>
