<?php
/**
 * Main Application Configuration
 */

// Timezone setup
date_default_timezone_set('Asia/Makassar');

// Dynamic Base URL definition
$host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1:8000';
if (strpos($host, '8000') !== false || strpos($host, '127.0.0.1') !== false) {
    define('BASE_URL', 'http://127.0.0.1:8000');
} else {
    define('BASE_URL', 'http://localhost/Prj%201/public');
}

// Application Constants
define('APP_NAME', 'PELAPORAN USAHA KETENAGALISTRIKAN KALIMANTAN SELATAN');
define('APP_SYSTEM_NAME', 'SISTEM INFORMASI DAN MONITORING USAHA KETENAGALISTRIKAN');
define('APP_AGENCY_NAME', 'DINAS ENERGI DAN SUMBER DAYA MINERAL PROVINSI KALIMANTAN SELATAN');
define('APP_UNIT', 'BIDANG KETENAGALISTRIKAN');
define('APP_VERSION', '1.0.0-2026');

// Session Setup
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}
