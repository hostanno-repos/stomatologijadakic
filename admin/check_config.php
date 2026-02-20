<?php
/**
 * Configuration Check Script
 * Access: yourdomain.com/admin/check_config.php
 * This will show current configuration values
 */

// Load config
define('ADMIN_PATH', __DIR__);
require_once ADMIN_PATH . '/config/config.php';

echo "<h1>Configuration Check</h1>";
echo "<h2>Database Settings:</h2>";
echo "<p>DB_HOST: " . DB_HOST . "</p>";
echo "<p>DB_NAME: " . DB_NAME . "</p>";
echo "<p>DB_USER: " . DB_USER . "</p>";
echo "<p>DB_PASS: " . (empty(DB_PASS) ? '(empty)' : '***hidden***') . "</p>";

echo "<h2>Application Settings:</h2>";
echo "<p>APP_URL: " . APP_URL . "</p>";
echo "<p>ADMIN_URL: " . ADMIN_URL . "</p>";

echo "<h2>Server Info:</h2>";
echo "<p>REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "</p>";
echo "<p>SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "</p>";
echo "<p>DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "</p>";
echo "<p>HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "</p>";

echo "<h2>Expected URLs:</h2>";
echo "<p>Login should be: " . ADMIN_URL . "/auth/login</p>";
echo "<p>Dashboard should be: " . ADMIN_URL . "/dashboard</p>";

echo "<h2>⚠️ IMPORTANT:</h2>";
echo "<p>If APP_URL shows 'localhost', you need to update it in <code>admin/config/config.php</code></p>";
echo "<p>Change line 24 from:</p>";
echo "<pre>define('APP_URL', 'http://localhost/dakic_cms');</pre>";
echo "<p>To:</p>";
echo "<pre>define('APP_URL', 'https://stomatologijadakic.com');</pre>";
