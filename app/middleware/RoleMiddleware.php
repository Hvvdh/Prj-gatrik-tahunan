<?php
/**
 * Role Middleware for RBAC
 */

require_once __DIR__ . '/../helpers/AuthHelper.php';

class RoleMiddleware {
    public static function allow($allowedRoles): void {
        AuthMiddleware::handle();

        if (!AuthHelper::hasRole($allowedRoles)) {
            set_flash('danger', 'Anda tidak memiliki hak akses untuk membuka halaman tersebut.');
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }
}
