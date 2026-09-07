<?php
/**
 * Formatting Helper Functions
 */

if (!function_exists('format_date')) {
    function format_date(?string $dateStr): string {
        if (empty($dateStr) || $dateStr === '0000-00-00') return '-';
        return date('d-m-Y', strtotime($dateStr));
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime(?string $dateStr): string {
        if (empty($dateStr)) return '-';
        return date('d-m-Y H:i', strtotime($dateStr));
    }
}

if (!function_exists('format_number')) {
    function format_number($number, int $decimals = 0): string {
        if (!is_numeric($number)) return '0';
        return number_format((float)$number, $decimals, ',', '.');
    }
}

if (!function_exists('get_status_badge')) {
    function get_status_badge(string $status): string {
        $statusUpper = strtoupper($status);
        switch ($statusUpper) {
            case 'DISETUJUI':
            case 'SUDAH_LAPOR':
            case 'AKTIF':
            case 'OPEN':
                return '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>' . e($status) . '</span>';
            case 'BELUM_LAPOR':
            case 'AKAN_BERAKHIR':
            case 'PERLU_PERBAIKAN':
                return '<span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>' . e($status) . '</span>';
            case 'TERLAMBAT':
            case 'DITOLAK':
            case 'KEDALUWARSA':
            case 'NONAKTIF':
                return '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>' . e($status) . '</span>';
            case 'DALAM_VERIFIKASI':
            case 'DIAJUKAN':
                return '<span class="badge bg-info text-dark"><i class="fas fa-spinner fa-spin me-1"></i>' . e($status) . '</span>';
            case 'DRAFT':
            default:
                return '<span class="badge bg-secondary"><i class="fas fa-file-alt me-1"></i>' . e($status) . '</span>';
        }
    }
}
