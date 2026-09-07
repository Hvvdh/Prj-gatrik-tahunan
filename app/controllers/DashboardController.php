<?php
/**
 * Dashboard Controller
 */

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';
require_once __DIR__ . '/../helpers/FormatterHelper.php';

class DashboardController {
    private PDO $db;

    public function __construct() {
        AuthMiddleware::handle();
        $this->db = Database::getConnection();
    }

    public function index(): void {
        $user = AuthHelper::user();

        // Query Database Statistics Dynamically
        $stats = [
            'total_companies'  => (int)$this->db->query("SELECT COUNT(*) FROM companies WHERE status='AKTIF'")->fetchColumn(),
            'total_iuptls'     => (int)$this->db->query("SELECT COUNT(*) FROM iuptls WHERE status='AKTIF'")->fetchColumn(),
            'total_stl'        => (int)$this->db->query("SELECT COUNT(*) FROM stl WHERE status='AKTIF'")->fetchColumn(),
            'total_iujptl'     => (int)$this->db->query("SELECT COUNT(*) FROM iujptl WHERE status='AKTIF'")->fetchColumn(),
            'total_generators' => (int)$this->db->query("SELECT COUNT(*) FROM generators WHERE status='OPERASIONAL'")->fetchColumn(),
            'total_capacity'   => (float)$this->db->query("SELECT COALESCE(SUM(kapasitas_kva), 0) FROM generators")->fetchColumn(),
            'total_technicians'=> (int)$this->db->query("SELECT COUNT(*) FROM technical_personnel WHERE status='AKTIF'")->fetchColumn(),
            'total_slo'        => (int)$this->db->query("SELECT COUNT(*) FROM slo WHERE status='AKTIF'")->fetchColumn(),
        ];

        // Reporting stats for dynamic year 2026
        $activeYear = 2026;
        $reportStats = [
            'total_wajib'     => (int)$this->db->query("SELECT COUNT(*) FROM companies WHERE status='AKTIF'")->fetchColumn(),
            'sudah_lapor'     => (int)$this->db->query("SELECT COUNT(*) FROM reports WHERE tahun_pelaporan={$activeYear} AND status='DISETUJUI'")->fetchColumn(),
            'dalam_verifikasi'=> (int)$this->db->query("SELECT COUNT(*) FROM reports WHERE tahun_pelaporan={$activeYear} AND status IN ('DIAJUKAN', 'DALAM_VERIFIKASI')")->fetchColumn(),
            'perlu_perbaikan' => (int)$this->db->query("SELECT COUNT(*) FROM reports WHERE tahun_pelaporan={$activeYear} AND status IN ('PERLU_PERBAIKAN', 'DITOLAK')")->fetchColumn(),
        ];

        $reportStats['belum_lapor'] = max(0, $reportStats['total_wajib'] - ($reportStats['sudah_lapor'] + $reportStats['dalam_verifikasi']));

        require __DIR__ . '/../views/dashboard/index.php';
    }
}
