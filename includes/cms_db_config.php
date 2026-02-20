<?php
/**
 * CMS Database Config - učitava kredencijale iz admin/config/config.php
 * Koriste: galerija.php, novosti.php, content_helper.php
 */
if (!defined('DB_HOST')) {
    define('ADMIN_PATH', dirname(__DIR__) . '/admin');
    require_once ADMIN_PATH . '/config/config.php';
}
