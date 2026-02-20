<?php
/**
 * Web-based Galleries Tables Installation Script
 * Access this file through your browser to set up galleries and images tables
 * Example: http://localhost/dakic_cms/admin/database/install_galleries_web.php
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Only allow in development (remove or secure this in production)
$allowed = true; // Set to false in production

if (!$allowed && php_sapi_name() !== 'cli') {
    die('Installation disabled. Please run from command line.');
}

define('ADMIN_PATH', dirname(__DIR__));
define('BASE_PATH', dirname(ADMIN_PATH));

// Database credentials
$dbHost = 'localhost';
$dbUser = 'doktordakic_dakic_cms';
$dbPass = '53rpWmwldqj1n2F4';
$dbName = 'doktordakic_dakic_cms';

$errors = [];
$success = [];
$step = $_GET['step'] ?? '1';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galleries Tables Installation - Dakic CMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .btn {
            background: #2c3e50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            margin-right: 10px;
        }
        .btn:hover {
            background: #34495e;
        }
        .btn-primary {
            background: #556ee6;
        }
        .btn-primary:hover {
            background: #4857d4;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
        }
        ul {
            margin: 10px 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Galleries Tables Installation</h1>
        
        <?php if ($step === '1'): ?>
            <div class="info">
                <p><strong>Before you begin:</strong></p>
                <ul>
                    <li>Make sure MySQL/MariaDB is running</li>
                    <li>Database credentials: Host: <code><?php echo $dbHost; ?></code>, User: <code><?php echo $dbUser; ?></code></li>
                    <li>Database <code><?php echo $dbName; ?></code> must already exist</li>
                    <li>Users table must already exist (run <code>install_web.php</code> first if needed)</li>
                    <li>This will create <code>galleries</code> and <code>images</code> tables</li>
                </ul>
            </div>
            
            <div class="warning">
                <p><strong>Note:</strong> If the tables already exist, they will not be overwritten. This script uses <code>CREATE TABLE IF NOT EXISTS</code>.</p>
            </div>
            
            <a href="?step=2" class="btn btn-primary">Create Galleries Tables</a>
            
        <?php elseif ($step === '2'): ?>
            <?php
            try {
                // Connect to database
                $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Check if users table exists
                $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
                if ($stmt->rowCount() === 0) {
                    $errors[] = "Users table does not exist. Please run install_web.php first to create the users table.";
                } else {
                    $success[] = "Users table found. Proceeding with galleries tables creation.";
                    
                    // Create galleries table
                    $createGalleriesTableSQL = "
                    CREATE TABLE IF NOT EXISTS `galleries` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `title` varchar(255) NOT NULL,
                      `slug` varchar(255) NOT NULL,
                      `description` text DEFAULT NULL,
                      `cover_image` varchar(255) DEFAULT NULL,
                      `status` enum('active','inactive') DEFAULT 'active',
                      `sort_order` int(11) DEFAULT 0,
                      `created_by` int(11) DEFAULT NULL,
                      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `slug` (`slug`),
                      KEY `status` (`status`),
                      KEY `sort_order` (`sort_order`),
                      KEY `created_by` (`created_by`),
                      CONSTRAINT `fk_galleries_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                    ";
                    
                    $pdo->exec($createGalleriesTableSQL);
                    $success[] = "Galleries table created successfully.";
                    
                    // Create images table
                    $createImagesTableSQL = "
                    CREATE TABLE IF NOT EXISTS `images` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `gallery_id` int(11) NOT NULL,
                      `title` varchar(255) DEFAULT NULL,
                      `filename` varchar(255) NOT NULL,
                      `original_filename` varchar(255) DEFAULT NULL,
                      `file_path` varchar(500) NOT NULL,
                      `file_size` int(11) DEFAULT NULL,
                      `mime_type` varchar(100) DEFAULT NULL,
                      `width` int(11) DEFAULT NULL,
                      `height` int(11) DEFAULT NULL,
                      `alt_text` varchar(255) DEFAULT NULL,
                      `description` text DEFAULT NULL,
                      `sort_order` int(11) DEFAULT 0,
                      `created_by` int(11) DEFAULT NULL,
                      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                      PRIMARY KEY (`id`),
                      KEY `gallery_id` (`gallery_id`),
                      KEY `sort_order` (`sort_order`),
                      KEY `created_by` (`created_by`),
                      CONSTRAINT `fk_images_gallery` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE,
                      CONSTRAINT `fk_images_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                    ";
                    
                    $pdo->exec($createImagesTableSQL);
                    $success[] = "Images table created successfully.";
                    
                    // Verify tables were created
                    $stmt = $pdo->query("SHOW TABLES LIKE 'galleries'");
                    $galleriesExists = $stmt->rowCount() > 0;
                    
                    $stmt = $pdo->query("SHOW TABLES LIKE 'images'");
                    $imagesExists = $stmt->rowCount() > 0;
                    
                    if ($galleriesExists && $imagesExists) {
                        $success[] = "Both tables verified successfully!";
                    }
                }
                
            } catch (PDOException $e) {
                $errors[] = "Error: " . $e->getMessage();
            }
            ?>
            
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
                
                <a href="?step=1" class="btn">Try Again</a>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <?php foreach ($success as $msg): ?>
                    <div class="success"><?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>
                
                <div class="info" style="margin-top: 20px;">
                    <p><strong>Installation completed successfully!</strong></p>
                    <p>The following tables have been created:</p>
                    <ul>
                        <li><code>galleries</code> - Stores gallery/album information</li>
                        <li><code>images</code> - Stores image information linked to galleries</li>
                    </ul>
                    <p>You can now use the Galleries section in the admin panel.</p>
                </div>
                
                <a href="../../galleries" class="btn btn-primary">Go to Galleries</a>
                <a href="?step=1" class="btn" style="background: #6c757d;">Run Again</a>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</body>
</html>
