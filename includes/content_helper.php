<?php
/**
 * Content Helper Functions
 * Functions for retrieving content from CMS on frontend
 * 
 * Usage:
 *   getContent('header', 'address') - Get specific content
 *   getContent('header', 'address', 'Default Address') - With fallback
 */

// Connect to CMS database
function getContentDB() {
    static $pdo = null;
    
    if ($pdo === null) {
        $dbHost = "localhost";
        $dbName = "doktordakic_dakic_cms";
        $dbUser = "doktordakic_dakic_cms";
        $dbPass = "53rpWmwldqj1n2F4";
        
        try {
            $pdo = new PDO(
                "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
                $dbUser,
                $dbPass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            error_log("Content DB Error: " . $e->getMessage());
            return null;
        }
    }
    
    return $pdo;
}

/**
 * Get content value by page and key
 * 
 * @param string $page Page identifier (e.g., 'header', 'footer', 'index')
 * @param string $key Key name (e.g., 'address', 'phone', 'title')
 * @param string $default Default value if content not found
 * @return string Content value or default
 */
function getContent($page, $key, $default = '') {
    $pdo = getContentDB();
    if (!$pdo) {
        return $default;
    }
    
    try {
        $stmt = $pdo->prepare("
            SELECT value FROM contents 
            WHERE page = ? AND key_name = ? 
            LIMIT 1
        ");
        $stmt->execute([$page, $key]);
        $result = $stmt->fetch();
        
        return $result ? $result['value'] : $default;
    } catch (PDOException $e) {
        error_log("Content fetch error: " . $e->getMessage());
        return $default;
    }
}

/**
 * Get all contents for a page
 * 
 * @param string $page Page identifier
 * @return array Array of contents with key_name => value
 */
function getContents($page) {
    $pdo = getContentDB();
    if (!$pdo) {
        return [];
    }
    
    try {
        $stmt = $pdo->prepare("
            SELECT key_name, value FROM contents 
            WHERE page = ? 
            ORDER BY key_name ASC
        ");
        $stmt->execute([$page]);
        $results = $stmt->fetchAll();
        
        $contents = [];
        foreach ($results as $result) {
            $contents[$result['key_name']] = $result['value'];
        }
        
        return $contents;
    } catch (PDOException $e) {
        error_log("Contents fetch error: " . $e->getMessage());
        return [];
    }
}

/**
 * Echo content (shorthand for echo getContent())
 * 
 * @param string $page Page identifier
 * @param string $key Key name
 * @param string $default Default value
 */
function content($page, $key, $default = '') {
    echo getContent($page, $key, $default);
}
