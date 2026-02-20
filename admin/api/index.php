<?php
/**
 * API Entry Point
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    define('ADMIN_PATH', dirname(__DIR__));
}

define('BASE_PATH', dirname(ADMIN_PATH));
define('ROOT_PATH', BASE_PATH);

// Set JSON header
header('Content-Type: application/json');

// Load configuration
require_once ADMIN_PATH . '/config/config.php';
require_once ADMIN_PATH . '/includes/autoloader.php';
require_once ADMIN_PATH . '/includes/bootstrap.php';

// Handle CORS if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/dakic_cms/admin/api', '', $path);
$path = trim($path, '/');

// Simple API router (can be expanded)
$response = [
    'status' => 'error',
    'message' => 'Endpoint not found',
    'data' => null
];

// Example API endpoints
if ($path === 'test' && $method === 'GET') {
    $response = [
        'status' => 'success',
        'message' => 'API is working',
        'data' => ['timestamp' => date('Y-m-d H:i:s')]
    ];
}

echo json_encode($response);
