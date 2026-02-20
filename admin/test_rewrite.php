<?php
/**
 * Test script to check if mod_rewrite is working
 * Access this file directly: http://localhost/dakic_cms/admin/test_rewrite.php
 */

echo "<h1>Apache mod_rewrite Test</h1>";

// Check if mod_rewrite is loaded
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    $rewrite_enabled = in_array('mod_rewrite', $modules);
    echo "<p><strong>mod_rewrite loaded:</strong> " . ($rewrite_enabled ? "YES ✓" : "NO ✗") . "</p>";
} else {
    echo "<p><strong>Note:</strong> Cannot check modules (apache_get_modules not available)</p>";
}

// Display server info
echo "<h2>Server Information</h2>";
echo "<p><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</p>";
echo "<p><strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "</p>";
echo "<p><strong>Script Name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "</p>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";

// Test .htaccess
echo "<h2>.htaccess Test</h2>";
$htaccess_path = __DIR__ . '/.htaccess';
if (file_exists($htaccess_path)) {
    echo "<p><strong>.htaccess exists:</strong> YES ✓</p>";
    echo "<p><strong>Path:</strong> " . $htaccess_path . "</p>";
    echo "<p><strong>Readable:</strong> " . (is_readable($htaccess_path) ? "YES ✓" : "NO ✗") . "</p>";
} else {
    echo "<p><strong>.htaccess exists:</strong> NO ✗</p>";
}

// Test if we can access index.php
echo "<h2>File Access Test</h2>";
$index_path = __DIR__ . '/index.php';
if (file_exists($index_path)) {
    echo "<p><strong>index.php exists:</strong> YES ✓</p>";
} else {
    echo "<p><strong>index.php exists:</strong> NO ✗</p>";
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li>If mod_rewrite is NOT loaded, enable it in WAMP: Apache → Apache modules → rewrite_module</li>";
echo "<li>If .htaccess doesn't exist, check file permissions</li>";
echo "<li>Try accessing: <a href='index.php'>index.php</a></li>";
echo "<li>Try accessing: <a href='auth/login'>auth/login</a> (should route through index.php)</li>";
echo "</ul>";
