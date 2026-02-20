<?php
/**
 * Custom CMS - Admin Panel Entry Point
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// #region agent log - EARLY LOGGING
$earlyLog = [
    'sessionId' => 'debug-session',
    'runId' => 'run3',
    'hypothesisId' => 'E',
    'location' => 'index.php:EARLY',
    'message' => 'Raw request received',
    'data' => [
        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'N/A',
        'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
        'HTTP_METHOD' => $_SERVER['HTTP_METHOD'] ?? 'N/A',
        'raw_post_data' => file_get_contents('php://input'),
        'has_post_superglobal' => !empty($_POST),
        'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'N/A'
    ],
    'timestamp' => time() * 1000
];
file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($earlyLog) . "\n", FILE_APPEND);
// #endregion

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    define('ADMIN_PATH', __DIR__);
}

// Define base paths
define('BASE_PATH', dirname(__DIR__));
define('ROOT_PATH', BASE_PATH);

// Configure session
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Load configuration first (needed for SESSION_NAME constant)
require_once ADMIN_PATH . '/config/config.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Load autoloader
require_once ADMIN_PATH . '/includes/autoloader.php';

// Load core classes
require_once ADMIN_PATH . '/includes/bootstrap.php';

// #region agent log
$logEntry = [
    'sessionId' => 'debug-session',
    'runId' => 'run2',
    'hypothesisId' => 'FIXED',
    'location' => 'index.php:39',
    'message' => 'AdminApp initialized - POST FIX',
    'data' => [
        'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
        'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? 'N/A',
        'admin_path' => ADMIN_PATH
    ],
    'timestamp' => time() * 1000
];
file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logEntry) . "\n", FILE_APPEND);
// #endregion

// Initialize application
$app = new AdminApp();
$app->run();
