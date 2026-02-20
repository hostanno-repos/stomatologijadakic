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
        if (!defined('DB_HOST')) {
            define('ADMIN_PATH', dirname(__DIR__) . '/admin');
            require_once ADMIN_PATH . '/config/config.php';
        }
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . (defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4'),
                DB_USER,
                DB_PASS,
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

/**
 * Default paths for site image slots (must match admin/config/site_images_slots.php).
 * Used when no custom image is set in admin.
 */
function getSiteImageDefaults() {
    return [
        'logo_header' => 'images/logo-horizontal.svg',
        'logo_footer' => 'images/logo-vertical.svg',
        'logo_sidemenu' => 'images/logo-horizontal.svg',
        'slider_1_left' => 'img/demos/dentist/slides/slide-dentist-1-1.jpg',
        'slider_1_right' => 'img/demos/dentist/slides/slide-dentist-1-2.jpg',
        'slider_2_bg' => 'img/demos/dentist/slides/slide-dentist-2-1.jpg',
        'slider_decor_1' => 'img/demos/dentist/generic/generic-3.svg',
        'slider_decor_2' => 'img/demos/dentist/generic/generic-4.svg',
        'index_hero' => 'img/demos/dentist/generic/generic-5.jpg',
        'index_box_icon1' => 'img/demos/dentist/icons/icon-1.svg',
        'index_box_icon2' => 'img/demos/dentist/icons/icon-2.svg',
        'index_box_icon3' => 'img/demos/dentist/icons/icon-3.svg',
        'usluge_ortodoncija' => 'img/usluge-slider/ortodoncija.jpg',
        'usluge_protetika' => 'img/usluge-slider/protetika.jpg',
        'usluge_estetika' => 'img/usluge-slider/estetika.jpg',
        'usluge_endodoncija' => 'img/usluge-slider/endodoncija.jpg',
        'usluge_implantologija' => 'img/usluge-slider/implantologija.jpg',
        'usluge_radiologija' => 'img/usluge-slider/radiologija.jpg',
        'usluge_hirurgija' => 'img/usluge-slider/hirurgija.jpg',
        'usluge_izbjeljivanje' => 'img/usluge-slider/izbjeljivanje.jpg',
        'usluge_laser' => 'img/usluge-slider/laser.png',
        'usluge_djecija' => 'img/djecija-stomatologija.jpg',
        'usluge_icon1' => 'img/usluge-slider/icon1.png',
        'usluge_icon2' => 'img/usluge-slider/icon2.png',
        'usluge_icon3' => 'img/usluge-slider/icon3.png',
        'usluge_icon4' => 'img/usluge-slider/icon4.png',
        'usluge_icon5' => 'img/usluge-slider/icon5.png',
        'usluge_icon6' => 'img/usluge-slider/icon6.png',
        'usluge_icon7' => 'img/usluge-slider/icon7.png',
        'onama_hero' => 'img/demos/dentist/generic/generic-5.jpg',
        'onama_service_1' => 'img/demos/dentist/services/service-1.jpg',
        'onama_service_2' => 'img/demos/dentist/services/service-2.jpg',
        'onama_service_3' => 'img/demos/dentist/services/service-3.jpg',
        'onama_service_4' => 'img/demos/dentist/services/service-4.jpg',
    ];
}

/**
 * Get site image path for a slot. Returns custom path from admin or default.
 *
 * @param string $key Slot key (e.g. logo_header, slider_1_left)
 * @return string Path relative to site root (for use in src="...")
 */
function getSiteImage($key) {
    $defaults = getSiteImageDefaults();
    $default = $defaults[$key] ?? '';
    $pdo = getContentDB();
    if (!$pdo) {
        return $default;
    }
    try {
        $stmt = $pdo->prepare("SELECT path FROM site_images WHERE `key` = ? LIMIT 1");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        if ($row && !empty($row['path'])) {
            return 'admin/' . ltrim($row['path'], '/');
        }
    } catch (PDOException $e) {
        error_log("Site image fetch error: " . $e->getMessage());
    }
    return $default;
}

/**
 * Get all employees for frontend (e.g. team section)
 *
 * @return array List of employees (id, first_name, last_name, position, description, sort_order)
 */
function getEmployees() {
    $pdo = getContentDB();
    if (!$pdo) {
        return [];
    }
    try {
        $stmt = $pdo->query("
            SELECT id, first_name, last_name, position, description, image, gender, sort_order
            FROM employees
            ORDER BY sort_order ASC, last_name ASC, first_name ASC
        ");
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    } catch (PDOException $e) {
        error_log("Employees fetch error: " . $e->getMessage());
        return [];
    }
}
