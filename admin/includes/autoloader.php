<?php
/**
 * Autoloader for Classes
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

spl_autoload_register(function ($class) {
    // Convert namespace to directory path
    $class = str_replace('\\', '/', $class);
    
    // Possible paths to check
    $paths = [
        ADMIN_PATH . '/classes/' . $class . '.php',
        ADMIN_PATH . '/models/' . $class . '.php',
        ADMIN_PATH . '/controllers/' . $class . '.php',
        ADMIN_PATH . '/helpers/' . $class . '.php',
        ADMIN_PATH . '/utils/' . $class . '.php',
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
