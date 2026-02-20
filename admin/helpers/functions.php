<?php
/**
 * Helper Functions
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

/**
 * Sanitize input
 */
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Escape output
 */
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Get current URL
 */
function currentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Log message
 */
function logMessage($message, $level = 'INFO') {
    if (!defined('LOG_ENABLED') || !LOG_ENABLED) {
        return;
    }
    if (!defined('LOG_PATH')) {
        return;
    }
    
    $logDir = rtrim(LOG_PATH, '/\\');
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    
    $logFile = LOG_PATH . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
    
    @file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Flash message
 */
function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}
