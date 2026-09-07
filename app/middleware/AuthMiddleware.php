<?php
/**
 * Auth Middleware
 */

require_once __DIR__ . '/../helpers/AuthHelper.php';

class AuthMiddleware {
    public static function handle(): void {
        if (!AuthHelper::check()) {
            set_flash('danger', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Check if forced password change is required
        $currentUri = $_SERVER['REQUEST_URI'] ?? '';
        if (AuthHelper::mustChangePassword() && strpos($currentUri, '/change-password') === false && strpos($currentUri, '/logout') === false) {
            set_flash('warning', 'Demi keamanan sistem, Anda diwajibkan mengubah password default terlebih dahulu.');
            header('Location: ' . BASE_URL . '/change-password');
            exit;
        }
    }
}
