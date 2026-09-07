<?php
/**
 * Simple Lightweight Router for Web Routes
 */

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../app/helpers/SanitizeHelper.php';
require_once __DIR__ . '/../app/helpers/FormatterHelper.php';
require_once __DIR__ . '/../app/helpers/AuthHelper.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';

function route_request(): void {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    
    // Normalize path by removing base folder from URI
    $path = str_replace($scriptName, '', $requestUri);
    $path = '/' . trim($path, '/');
    if ($path === '/public' || $path === '/public/') {
        $path = '/';
    } else {
        $path = str_replace('/public', '', $path);
    }
    if (empty($path)) $path = '/';

    $method = $_SERVER['REQUEST_METHOD'];

    // Route Mapping
    if ($path === '/' || $path === '/login') {
        $controller = new AuthController();
        if ($method === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        return;
    }

    if ($path === '/auth/login' && $method === 'POST') {
        $controller = new AuthController();
        $controller->login();
        return;
    }

    if ($path === '/auth/logout' || $path === '/logout') {
        $controller = new AuthController();
        $controller->logout();
        return;
    }

    if ($path === '/change-password') {
        $controller = new AuthController();
        if ($method === 'POST') {
            $controller->updatePassword();
        } else {
            $controller->showChangePassword();
        }
        return;
    }

    if ($path === '/auth/update-password' && $method === 'POST') {
        $controller = new AuthController();
        $controller->updatePassword();
        return;
    }

    if ($path === '/dashboard') {
        $controller = new DashboardController();
        $controller->index();
        return;
    }

    // Default Fallback Route
    if (AuthHelper::check()) {
        $controller = new DashboardController();
        $controller->index();
    } else {
        $controller = new AuthController();
        $controller->showLogin();
    }
}
