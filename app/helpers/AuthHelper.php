<?php
/**
 * Authentication & RBAC Helper Functions
 */

require_once __DIR__ . '/../../config/database.php';

class AuthHelper {

    public static function check(): bool {
        return !empty($_SESSION['user_id']);
    }

    public static function user(): ?array {
        if (!self::check()) return null;
        
        if (!isset($_SESSION['user_data'])) {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                SELECT u.*, r.name as role_name, r.display_name as role_display_name, c.nama_perusahaan 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                LEFT JOIN companies c ON u.company_id = c.id 
                WHERE u.id = :id
            ");
            $stmt->execute([':id' => $_SESSION['user_id']]);
            $_SESSION['user_data'] = $stmt->fetch();
        }

        return $_SESSION['user_data'];
    }

    public static function role(): ?string {
        $user = self::user();
        return $user ? $user['role_name'] : null;
    }

    public static function hasRole($roles): bool {
        $userRole = self::role();
        if (!$userRole) return false;

        if (is_array($roles)) {
            return in_array($userRole, $roles);
        }
        return $userRole === $roles;
    }

    public static function hasPermission(string $permissionName): bool {
        if (!self::check()) return false;
        
        // Super admin has all permissions
        if (self::role() === 'SUPER_ADMIN') return true;

        if (!isset($_SESSION['user_permissions'])) {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                SELECT p.name 
                FROM permissions p
                JOIN role_permissions rp ON p.id = rp.permission_id
                WHERE rp.role_id = :role_id
            ");
            $stmt->execute([':role_id' => $_SESSION['user_data']['role_id']]);
            $_SESSION['user_permissions'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        return in_array($permissionName, $_SESSION['user_permissions']);
    }

    public static function mustChangePassword(): bool {
        $user = self::user();
        return $user && (bool)$user['must_change_password'];
    }

    public static function login(array $user): void {
        $_SESSION['user_id'] = $user['id'];
        unset($_SESSION['user_data']);
        unset($_SESSION['user_permissions']);
        
        // Update last login at
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET last_login_at = NOW() WHERE id = :id");
        $stmt->execute([':id' => $user['id']]);

        // Audit log
        self::logAudit('LOGIN_SUCCESS', 'auth', $user['id'], 'User login berhasil: ' . $user['username']);
    }

    public static function logout(): void {
        if (self::check()) {
            $userId = $_SESSION['user_id'];
            $username = $_SESSION['user_data']['username'] ?? 'User';
            self::logAudit('LOGOUT', 'auth', $userId, 'User logout: ' . $username);
        }
        unset($_SESSION['user_id']);
        unset($_SESSION['user_data']);
        unset($_SESSION['user_permissions']);
        session_destroy();
    }

    public static function logAudit(string $action, string $module, ?int $recordId = null, ?string $description = null): void {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                INSERT INTO audit_logs (user_id, action, module, record_id, description, ip_address, user_agent, created_at)
                VALUES (:user_id, :action, :module, :record_id, :description, :ip, :ua, NOW())
            ");
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'] ?? null,
                ':action' => $action,
                ':module' => $module,
                ':record_id' => $recordId,
                ':description' => $description,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                ':ua' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 250)
            ]);
        } catch (Exception $e) {
            // Ignore audit log error to not block user flow
        }
    }
}
