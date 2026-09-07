<?php
/**
 * User Model
 */

require_once __DIR__ . '/../../config/database.php';

class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare("
            SELECT u.*, r.name as role_name, r.display_name as role_display_name 
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.username = :username AND u.status = 'AKTIF'
            LIMIT 1
        ");
        $stmt->execute([':username' => $username]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("
            SELECT u.*, r.name as role_name, r.display_name as role_display_name, c.nama_perusahaan
            FROM users u
            JOIN roles r ON u.role_id = r.id
            LEFT JOIN companies c ON u.company_id = c.id
            WHERE u.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function updatePassword(int $userId, string $newPassword): bool {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
            UPDATE users 
            SET password_hash = :hash, must_change_password = 0, updated_at = NOW() 
            WHERE id = :id
        ");
        return $stmt->execute([
            ':hash' => $hash,
            ':id' => $userId
        ]);
    }
}
