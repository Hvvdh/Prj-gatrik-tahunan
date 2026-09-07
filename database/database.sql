-- ============================================================
-- DATABASE CREATION SCRIPT: SISTEM INFORMASI & MONITORING WASDAL GATRIK KALSEL
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_wasdalgatrik_kalsel DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_wasdalgatrik_kalsel;

-- Disable FK checks for clean setup
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS report_approvals;
DROP TABLE IF EXISTS report_verifications;
DROP TABLE IF EXISTS report_documents;
DROP TABLE IF EXISTS report_production_details;
DROP TABLE IF EXISTS report_details;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS reporting_periods;
DROP TABLE IF EXISTS slo;
DROP TABLE IF EXISTS competency_certificates;
DROP TABLE IF EXISTS technical_personnel;
DROP TABLE IF EXISTS generators;
DROP TABLE IF EXISTS iujptl;
DROP TABLE IF EXISTS stl;
DROP TABLE IF EXISTS iuptls;
DROP TABLE IF EXISTS business_licenses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS companies;
DROP TABLE IF EXISTS subdistricts;
DROP TABLE IF EXISTS districts;
DROP TABLE IF EXISTS role_permissions;
DROP TABLE IF EXISTS permissions;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS settings;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. ROLES
CREATE TABLE roles (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. PERMISSIONS
CREATE TABLE permissions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    module VARCHAR(50) NOT NULL,
    description VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. ROLE PERMISSIONS
CREATE TABLE role_permissions (
    role_id BIGINT NOT NULL,
    permission_id BIGINT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. DISTRICTS (KABUPATEN/KOTA KALSEL)
CREATE TABLE districts (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. SUBDISTRICTS (KECAMATAN)
CREATE TABLE subdistricts (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    district_id BIGINT NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    FOREIGN KEY (district_id) REFERENCES districts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. COMPANIES (DATA PERUSAHAAN)
CREATE TABLE companies (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nama_perusahaan VARCHAR(255) NOT NULL,
    nib VARCHAR(50) NOT NULL UNIQUE,
    npwp VARCHAR(50) NULL,
    alamat TEXT NOT NULL,
    district_id BIGINT NOT NULL,
    subdistrict_id BIGINT NULL,
    desa VARCHAR(100) NULL,
    telepon VARCHAR(30) NULL,
    email VARCHAR(100) NULL,
    penanggung_jawab VARCHAR(100) NOT NULL,
    nomor_hp VARCHAR(30) NOT NULL,
    latitude DECIMAL(10,8) NULL,
    longitude DECIMAL(11,8) NULL,
    status ENUM('AKTIF', 'NONAKTIF') DEFAULT 'AKTIF',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (district_id) REFERENCES districts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. USERS
CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(30) NULL,
    role_id BIGINT NOT NULL,
    company_id BIGINT NULL,
    must_change_password BOOLEAN NOT NULL DEFAULT TRUE,
    status ENUM('AKTIF', 'NONAKTIF') DEFAULT 'AKTIF',
    last_login_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. BUSINESS LICENCES (IZIN UTAMA)
CREATE TABLE business_licenses (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    nomor_izin VARCHAR(100) NOT NULL,
    jenis_izin ENUM('IUPTLS', 'STL', 'IUJPTL') NOT NULL,
    tanggal_izin DATE NOT NULL,
    masa_berlaku DATE NULL,
    kapasitas DECIMAL(12,2) NULL,
    satuan VARCHAR(20) DEFAULT 'kVA',
    lokasi TEXT NULL,
    district_id BIGINT NULL,
    status ENUM('AKTIF', 'AKAN_BERAKHIR', 'KEDALUWARSA') DEFAULT 'AKTIF',
    file_path VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY (district_id) REFERENCES districts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. IUPTLS
CREATE TABLE iuptls (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    nomor_iuptls VARCHAR(100) NOT NULL UNIQUE,
    tanggal_izin DATE NOT NULL,
    kapasitas DECIMAL(12,2) NOT NULL,
    satuan VARCHAR(20) DEFAULT 'kVA',
    lokasi TEXT NOT NULL,
    district_id BIGINT NOT NULL,
    subdistrict_id BIGINT NULL,
    status ENUM('AKTIF', 'NONAKTIF') DEFAULT 'AKTIF',
    file_path VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY (district_id) REFERENCES districts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. STL (SURAT TANDA LAPOR)
CREATE TABLE stl (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    nomor_stl VARCHAR(100) NOT NULL UNIQUE,
    tanggal_stl DATE NOT NULL,
    pembangkit VARCHAR(150) NOT NULL,
    kapasitas DECIMAL(12,2) NOT NULL,
    lokasi TEXT NOT NULL,
    status ENUM('AKTIF', 'NONAKTIF') DEFAULT 'AKTIF',
    file_path VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. IUJPTL (IZIN JASA)
CREATE TABLE iujptl (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    nomor_iujptl VARCHAR(100) NOT NULL UNIQUE,
    tanggal_izin DATE NOT NULL,
    jenis_jasa VARCHAR(255) NOT NULL,
    klasifikasi VARCHAR(150) NULL,
    wilayah_kerja VARCHAR(255) NULL,
    status ENUM('AKTIF', 'NONAKTIF') DEFAULT 'AKTIF',
    file_path VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. GENERATORS (PEMBANGKIT)
CREATE TABLE generators (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    jenis_pembangkit VARCHAR(100) NOT NULL, -- Diesel / Genset, PLTU, PLTA, Solar, dll
    merk VARCHAR(100) NULL,
    tipe VARCHAR(100) NULL,
    kapasitas_kva DECIMAL(12,2) DEFAULT 0.00,
    kapasitas_kw DECIMAL(12,2) DEFAULT 0.00,
    jumlah_unit INT DEFAULT 1,
    bahan_bakar VARCHAR(100) NULL,
    tahun_instalasi INT NULL,
    lokasi TEXT NULL,
    latitude DECIMAL(10,8) NULL,
    longitude DECIMAL(11,8) NULL,
    status ENUM('OPERASIONAL', 'RUSAK', 'STANDBY', 'NONAKTIF') DEFAULT 'OPERASIONAL',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. TECHNICAL PERSONNEL (TENAGA TEKNIK)
CREATE TABLE technical_personnel (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    nik VARCHAR(20) NOT NULL,
    jabatan VARCHAR(100) NULL,
    bidang_kompetensi VARCHAR(150) NOT NULL,
    jenjang VARCHAR(50) NULL,
    nomor_sertifikat VARCHAR(100) NULL,
    lembaga_sertifikasi VARCHAR(150) NULL,
    tanggal_terbit DATE NULL,
    tanggal_berlaku DATE NULL,
    status ENUM('AKTIF', 'AKAN_BERAKHIR', 'KEDALUWARSA') DEFAULT 'AKTIF',
    file_path VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. COMPETENCY CERTIFICATES
CREATE TABLE competency_certificates (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    technical_personnel_id BIGINT NOT NULL,
    nomor_sertifikat VARCHAR(100) NOT NULL,
    bidang VARCHAR(150) NOT NULL,
    jenjang VARCHAR(50) NULL,
    lembaga_sertifikasi VARCHAR(150) NOT NULL,
    tanggal_terbit DATE NOT NULL,
    tanggal_berlaku DATE NOT NULL,
    file_path VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (technical_personnel_id) REFERENCES technical_personnel(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. SLO (SERTIFIKAT LAIK OPERASI)
CREATE TABLE slo (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    nomor_slo VARCHAR(100) NOT NULL UNIQUE,
    instalasi VARCHAR(255) NOT NULL,
    kapasitas DECIMAL(12,2) NOT NULL,
    lokasi TEXT NOT NULL,
    lembaga_inspeksi VARCHAR(150) NOT NULL,
    tanggal_terbit DATE NOT NULL,
    tanggal_berlaku DATE NOT NULL,
    status ENUM('AKTIF', 'AKAN_BERAKHIR', 'KEDALUWARSA') DEFAULT 'AKTIF',
    file_path VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. REPORTING PERIODS (PERIODE TAHUNAN DINAMIS)
CREATE TABLE reporting_periods (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    year INT NOT NULL UNIQUE,
    start_date DATE NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('OPEN', 'CLOSED', 'ARCHIVED') DEFAULT 'OPEN',
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 17. REPORTS (LAPORAN TAHUNAN UTAMA)
CREATE TABLE reports (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    company_id BIGINT NOT NULL,
    reporting_period_id BIGINT NOT NULL,
    report_type ENUM('IUPTLS', 'STL', 'IUJPTL') NOT NULL,
    tahun_pelaporan INT NOT NULL,
    report_number VARCHAR(100) NOT NULL UNIQUE,
    status ENUM('DRAFT', 'DIAJUKAN', 'DALAM_VERIFIKASI', 'DISETUJUI', 'DITOLAK', 'PERLU_PERBAIKAN') DEFAULT 'DRAFT',
    submitted_at DATETIME NULL,
    verified_at DATETIME NULL,
    approved_at DATETIME NULL,
    verification_code VARCHAR(100) NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY (reporting_period_id) REFERENCES reporting_periods(id),
    UNIQUE KEY uk_company_report_year (company_id, report_type, tahun_pelaporan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 18. REPORT DETAILS
CREATE TABLE report_details (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    report_id BIGINT NOT NULL,
    kapasitas DECIMAL(15,2) DEFAULT 0.00,
    jam_operasi_tahunan DECIMAL(10,2) DEFAULT 0.00,
    produksi_listrik_tahunan DECIMAL(15,2) DEFAULT 0.00,
    pemakaian_sendiri DECIMAL(15,2) DEFAULT 0.00,
    bahan_bakar VARCHAR(100) NULL,
    konsumsi_bahan_bakar DECIMAL(15,2) DEFAULT 0.00,
    keterangan TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 19. REPORT PRODUCTION DETAILS (12 MONTHS RINCIAN PRODUKSI)
CREATE TABLE report_production_details (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    report_id BIGINT NOT NULL,
    month INT NOT NULL COMMENT '1=Jan, 2=Feb, ..., 12=Des',
    production_kwh DECIMAL(15,2) DEFAULT 0.00,
    production_mwh DECIMAL(15,2) DEFAULT 0.00,
    operating_hours DECIMAL(8,2) DEFAULT 0.00,
    fuel_consumption DECIMAL(12,2) DEFAULT 0.00,
    description VARCHAR(255) NULL,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE,
    UNIQUE KEY uk_report_month (report_id, month)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 20. REPORT DOCUMENTS
CREATE TABLE report_documents (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    report_id BIGINT NOT NULL,
    document_type VARCHAR(100) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 21. REPORT VERIFICATIONS
CREATE TABLE report_verifications (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    report_id BIGINT NOT NULL,
    verified_by BIGINT NOT NULL,
    status VARCHAR(50) NOT NULL,
    notes TEXT NULL,
    verified_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 22. REPORT APPROVALS
CREATE TABLE report_approvals (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    report_id BIGINT NOT NULL,
    approved_by BIGINT NOT NULL,
    status VARCHAR(50) NOT NULL,
    notes TEXT NULL,
    approved_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 23. NOTIFICATIONS
CREATE TABLE notifications (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50) DEFAULT 'INFO',
    is_read BOOLEAN DEFAULT FALSE,
    link VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 24. AUDIT LOGS
CREATE TABLE audit_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NULL,
    action VARCHAR(100) NOT NULL,
    module VARCHAR(100) NOT NULL,
    record_id BIGINT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 25. SETTINGS
CREATE TABLE settings (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    `group` VARCHAR(50) DEFAULT 'general',
    label VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- SEED DATA SETUP
-- ============================================================

-- Seed Roles
INSERT INTO roles (id, name, display_name, description) VALUES
(1, 'SUPER_ADMIN', 'Super Admin', 'Akses penuh ke seluruh konfigurasi & fitur sistem'),
(2, 'ADMIN_INSTANSI', 'Administrator Instansi', 'Akses pengelolaan perizinan, verifikasi, approval, dan monitoring'),
(3, 'OPERATOR', 'Operator', 'Akses input data, pemeriksaan berkas administrasi, dan pendataan'),
(4, 'PELAKU_USAHA', 'Pelaku Usaha', 'Akses pengisian profil, perizinan, dan laporan tahunan perusahaan'),
(5, 'PIMPINAN', 'Pimpinan', 'Akses Read-Only ke dashboard eksekutif, statistik, dan peta GIS');

-- Seed Permissions
INSERT INTO permissions (id, name, module, description) VALUES
(1, 'manage_users', 'users', 'Mengelola data pengguna dan hak akses'),
(2, 'manage_companies', 'companies', 'Mengelola data master perusahaan'),
(3, 'manage_licenses', 'licenses', 'Mengelola data perizinan usaha (IUPTLS, STL, IUJPTL)'),
(4, 'manage_generators', 'generators', 'Mengelola data pembangkit listrik'),
(5, 'manage_technical', 'technical', 'Mengelola data tenaga teknik & SKTTK'),
(6, 'manage_slo', 'slo', 'Mengelola data Sertifikat Laik Operasi'),
(7, 'manage_report_periods', 'settings', 'Mengatur periode tahunan pelaporan'),
(8, 'submit_reports', 'reports', 'Membuat dan mengajukan Laporan Tahunan'),
(9, 'verify_reports', 'verification', 'Memeriksa dan melakukan verifikasi berkas laporan'),
(10, 'approve_reports', 'approval', 'Menyetujui atau menolak laporan tahunan'),
(11, 'view_executive_dashboard', 'dashboard', 'Melihat dashboard statistik & eksekutif pimpinan'),
(12, 'view_audit_logs', 'logs', 'Melihat catatan audit log transaksi sistem'),
(13, 'manage_settings', 'settings', 'Mengelola pengaturan global sistem');

-- Role Permissions Mapping
-- Super Admin (All Permissions)
INSERT INTO role_permissions (role_id, permission_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10), (1, 11), (1, 12), (1, 13);

-- Administrator Instansi
INSERT INTO role_permissions (role_id, permission_id) VALUES
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6), (2, 7), (2, 9), (2, 10), (2, 11), (2, 12), (2, 13);

-- Operator
INSERT INTO role_permissions (role_id, permission_id) VALUES
(3, 2), (3, 3), (3, 4), (3, 5), (3, 6), (3, 9), (3, 11);

-- Pelaku Usaha
INSERT INTO role_permissions (role_id, permission_id) VALUES
(4, 8);

-- Pimpinan
INSERT INTO role_permissions (role_id, permission_id) VALUES
(5, 11);

-- Seed Default Admin User: `wasdalgatrik`
-- Password initial: `listrik22` (Hashed using PASSWORD_DEFAULT)
-- `$2y$10$hrGDCqOHaK2v3Ereeq73S.Eil70Lfj.2kKYqyb/Z2DmwGBJbiVmaS`
INSERT INTO users (id, username, password_hash, full_name, email, phone, role_id, company_id, must_change_password, status) VALUES
(1, 'wasdalgatrik', '$2y$10$hrGDCqOHaK2v3Ereeq73S.Eil70Lfj.2kKYqyb/Z2DmwGBJbiVmaS', 'Administrator Wasdal Gatrik', 'wasdalgatrik@kalselprov.go.id', '08115000000', 2, NULL, 1, 'AKTIF');

-- Seed Super Admin & Pimpinan User for completeness
INSERT INTO users (id, username, password_hash, full_name, email, phone, role_id, company_id, must_change_password, status) VALUES
(2, 'superadmin', '$2y$10$hrGDCqOHaK2v3Ereeq73S.Eil70Lfj.2kKYqyb/Z2DmwGBJbiVmaS', 'Super Administrator ESDM', 'admin.esdm@kalselprov.go.id', '08115000001', 1, NULL, 0, 'AKTIF'),
(3, 'pimpinan', '$2y$10$hrGDCqOHaK2v3Ereeq73S.Eil70Lfj.2kKYqyb/Z2DmwGBJbiVmaS', 'Kepala Dinas ESDM Kalsel', 'kadis.esdm@kalselprov.go.id', '08115000002', 5, NULL, 0, 'AKTIF');

-- Seed Districts Kalsel (13 Kabupaten/Kota)
INSERT INTO districts (id, name, code) VALUES
(1, 'Kota Banjarmasin', '63.71'),
(2, 'Kota Banjarbaru', '63.72'),
(3, 'Kabupaten Banjar', '63.03'),
(4, 'Kabupaten Tanah Laut', '63.01'),
(5, 'Kabupaten Barito Kuala', '63.04'),
(6, 'Kabupaten Tapin', '63.05'),
(7, 'Kabupaten Hulu Sungai Selatan', '63.06'),
(8, 'Kabupaten Hulu Sungai Tengah', '63.07'),
(9, 'Kabupaten Hulu Sungai Utara', '63.08'),
(10, 'Kabupaten Tabalong', '63.09'),
(11, 'Kabupaten Tanah Bumbu', '63.10'),
(12, 'Kabupaten Kotabaru', '63.02'),
(13, 'Kabupaten Balangan', '63.11');

-- Seed Initial Reporting Period 2026
INSERT INTO reporting_periods (id, year, start_date, due_date, status, description) VALUES
(1, 2026, '2026-01-01', '2026-03-31', 'OPEN', 'Periode Pelaporan Tahunan Usaha Ketenagalistrikan Tahun 2026');

-- Seed Settings
INSERT INTO settings (setting_key, setting_value, `group`, label) VALUES
('app_name', 'PELAPORAN USAHA KETENAGALISTRIKAN KALIMANTAN SELATAN', 'general', 'Nama Aplikasi'),
('app_system_name', 'SISTEM INFORMASI DAN MONITORING USAHA KETENAGALISTRIKAN PROVINSI KALIMANTAN SELATAN', 'general', 'Nama Sistem'),
('agency_name', 'DINAS ENERGI DAN SUMBER DAYA MINERAL PROVINSI KALIMANTAN SELATAN', 'general', 'Nama Instansi'),
('active_year', '2026', 'general', 'Tahun Pelaporan Aktif'),
('contact_email', 'esdm@kalselprov.go.id', 'general', 'Email Kontak'),
('contact_phone', '(0511) 4772345', 'general', 'Telepon Kontak'),
('contact_address', 'Jl. Jend. A. Yani Km. 34.5 Banjarbaru, Kalimantan Selatan', 'general', 'Alamat Instansi');
