<?php
/**
 * Auth Controller
 */

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';
require_once __DIR__ . '/../helpers/SanitizeHelper.php';

class AuthController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showLogin(): void {
        if (AuthHelper::check()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function login(): void {
        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf_token($token)) {
            set_flash('danger', 'Sesi form telah kedaluwarsa. Silakan coba lagi.');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            set_flash('danger', 'Username dan password wajib diisi.');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password_hash'])) {
            AuthHelper::login($user);

            if ((bool)$user['must_change_password']) {
                set_flash('warning', 'Untuk keamanan sistem, Anda diwajibkan mengubah password default terlebih dahulu.');
                header('Location: ' . BASE_URL . '/change-password');
                exit;
            }

            set_flash('success', 'Selamat datang kembali, ' . e($user['full_name']) . '!');
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        AuthHelper::logAudit('LOGIN_FAILED', 'auth', null, 'Percobaan login gagal untuk username: ' . $username);
        set_flash('danger', 'Username atau password yang Anda masukkan salah.');
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function logout(): void {
        AuthHelper::logout();
        set_flash('success', 'Anda telah berhasil keluar dari sistem.');
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function showChangePassword(): void {
        if (!AuthHelper::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require __DIR__ . '/../views/auth/change_password.php';
    }

    public function updatePassword(): void {
        if (!AuthHelper::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf_token($token)) {
            set_flash('danger', 'Sesi form telah kedaluwarsa. Silakan coba lagi.');
            header('Location: ' . BASE_URL . '/change-password');
            exit;
        }

        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (strlen($newPassword) < 6) {
            set_flash('danger', 'Password baru minimal harus terdiri dari 6 karakter.');
            header('Location: ' . BASE_URL . '/change-password');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            set_flash('danger', 'Konfirmasi password baru tidak cocok.');
            header('Location: ' . BASE_URL . '/change-password');
            exit;
        }

        $userId = $_SESSION['user_id'];
        if ($this->userModel->updatePassword($userId, $newPassword)) {
            // Update session data
            $_SESSION['user_data']['must_change_password'] = 0;
            AuthHelper::logAudit('PASSWORD_CHANGED', 'auth', $userId, 'User memperbarui password');

            set_flash('success', 'Password Anda berhasil diperbarui. Selamat datang di sistem!');
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        set_flash('danger', 'Gagal memperbarui password. Silakan coba lagi.');
        header('Location: ' . BASE_URL . '/change-password');
        exit;
    }
}
