<?php
/**
 * Bootstrap File - Loads core functionality
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

// Load helper functions
require_once ADMIN_PATH . '/helpers/functions.php';

// Load security functions
require_once ADMIN_PATH . '/helpers/security.php';

// Load database
require_once ADMIN_PATH . '/config/database.php';
