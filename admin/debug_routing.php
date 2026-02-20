<?php
/**
 * Debug routing - logs request information
 * Access: http://localhost/dakic_cms/admin/debug_routing.php
 */

// #region agent log
$logData = [
    'sessionId' => 'debug-session',
    'runId' => 'run1',
    'hypothesisId' => 'A,B,C,D,E',
    'location' => 'debug_routing.php:10',
    'message' => 'Routing debug started',
    'data' => [
        'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
        'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? 'N/A',
        'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
        'PHP_SELF' => $_SERVER['PHP_SELF'] ?? 'N/A',
        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'N/A'
    ],
    'timestamp' => time() * 1000
];
file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logData) . "\n", FILE_APPEND);
// #endregion

echo "<h1>Routing Debug Information</h1>";

echo "<h2>Server Variables</h2>";
echo "<table border='1' cellpadding='5'>";
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'HTTP_') === 0 || in_array($key, ['REQUEST_URI', 'SCRIPT_NAME', 'DOCUMENT_ROOT', 'PHP_SELF', 'REQUEST_METHOD', 'QUERY_STRING'])) {
        echo "<tr><td><strong>{$key}</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
    }
}
echo "</table>";

// #region agent log
$logData2 = [
    'sessionId' => 'debug-session',
    'runId' => 'run1',
    'hypothesisId' => 'B',
    'location' => 'debug_routing.php:35',
    'message' => 'Calculated paths',
    'data' => [
        'calculated_base' => '/dakic_cms/admin/',
        'request_uri_path' => parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH),
        'expected_match' => preg_match('#^/dakic_cms/admin/#', $_SERVER['REQUEST_URI'] ?? '')
    ],
    'timestamp' => time() * 1000
];
file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logData2) . "\n", FILE_APPEND);
// #endregion

echo "<h2>Path Analysis</h2>";
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';

echo "<p><strong>Request URI:</strong> " . htmlspecialchars($requestUri) . "</p>";
echo "<p><strong>Script Name:</strong> " . htmlspecialchars($scriptName) . "</p>";
echo "<p><strong>Document Root:</strong> " . htmlspecialchars($docRoot) . "</p>";

$expectedBase = '/dakic_cms/admin/';
$matchesBase = preg_match('#^' . preg_quote($expectedBase, '#') . '#', $requestUri);
echo "<p><strong>Matches expected base ({$expectedBase}):</strong> " . ($matchesBase ? "YES ✓" : "NO ✗") . "</p>";

// #region agent log
$logData3 = [
    'sessionId' => 'debug-session',
    'runId' => 'run1',
    'hypothesisId' => 'A',
    'location' => 'debug_routing.php:55',
    'message' => 'File existence check',
    'data' => [
        'index_exists' => file_exists(__DIR__ . '/index.php'),
        'htaccess_exists' => file_exists(__DIR__ . '/.htaccess'),
        'admin_dir' => __DIR__
    ],
    'timestamp' => time() * 1000
];
file_put_contents('C:\\wamp64\\www\\dakic_cms\\.cursor\\debug.log', json_encode($logData3) . "\n", FILE_APPEND);
// #endregion

echo "<h2>File Checks</h2>";
echo "<p><strong>index.php exists:</strong> " . (file_exists(__DIR__ . '/index.php') ? "YES ✓" : "NO ✗") . "</p>";
echo "<p><strong>.htaccess exists:</strong> " . (file_exists(__DIR__ . '/.htaccess') ? "YES ✓" : "NO ✗") . "</p>";
echo "<p><strong>Admin directory:</strong> " . __DIR__ . "</p>";

echo "<h2>Test Links</h2>";
echo "<ul>";
echo "<li><a href='index.php'>Direct index.php</a></li>";
echo "<li><a href='auth/login'>auth/login (should rewrite)</a></li>";
echo "<li><a href='test_rewrite.php'>test_rewrite.php</a></li>";
echo "</ul>";
