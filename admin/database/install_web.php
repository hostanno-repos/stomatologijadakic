<?php
/**
 * Web-based Database Installation Script
 * Access this file through your browser to set up the database
 * Example: http://localhost/dakic_cms/admin/database/install_web.php
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Only allow in development (remove or secure this in production)
$allowed = true; // Set to false in production

if (!$allowed && php_sapi_name() !== 'cli') {
    die('Installation disabled. Please run install.php from command line.');
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
    <title>Database Installation - Dakic CMS</title>
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
        }
        .btn:hover {
            background: #34495e;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Installation</h1>
        
        <?php if ($step === '1'): ?>
            <div class="info">
                <p><strong>Before you begin:</strong></p>
                <ul>
                    <li>Make sure MySQL/MariaDB is running</li>
                    <li>Database credentials: Host: <code><?php echo $dbHost; ?></code>, User: <code><?php echo $dbUser; ?></code></li>
                    <li>This will create database <code><?php echo $dbName; ?></code> and users table</li>
                </ul>
            </div>
            
            <a href="?step=2" class="btn">Start Installation</a>
            
        <?php elseif ($step === '2'): ?>
            <?php
            try {
                // Connect to MySQL server (without database)
                $pdo = new PDO("mysql:host={$dbHost};charset=utf8mb4", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Create database
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $success[] = "Database '{$dbName}' created successfully.";
                
                // Select database
                $pdo->exec("USE `{$dbName}`");
                
                // Create users table
                $createTableSQL = "
                CREATE TABLE IF NOT EXISTS `users` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `username` varchar(50) NOT NULL,
                  `email` varchar(100) NOT NULL,
                  `password` varchar(255) NOT NULL,
                  `first_name` varchar(50) DEFAULT NULL,
                  `last_name` varchar(50) DEFAULT NULL,
                  `role` enum('admin','editor','author') DEFAULT 'author',
                  `status` enum('active','inactive','suspended') DEFAULT 'active',
                  `last_login` datetime DEFAULT NULL,
                  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `username` (`username`),
                  UNIQUE KEY `email` (`email`),
                  KEY `status` (`status`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ";
                
                $pdo->exec($createTableSQL);
                $success[] = "Users table created successfully.";
                
                // Check if admin user exists
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = 'admin'");
                $stmt->execute();
                $userExists = $stmt->fetchColumn() > 0;
                
                if (!$userExists) {
                    // Create default admin user
                    $passwordHash = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]);
                    
                    $stmt = $pdo->prepare("
                        INSERT INTO `users` (`username`, `email`, `password`, `first_name`, `last_name`, `role`, `status`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)
                    ");
                    
                    $stmt->execute([
                        'admin',
                        'admin@dakic-cms.com',
                        $passwordHash,
                        'Admin',
                        'User',
                        'admin',
                        'active'
                    ]);
                    
                    $success[] = "Default admin user created successfully.";
                } else {
                    $success[] = "Admin user already exists.";
                }
                
            } catch (PDOException $e) {
                $errors[] = "Error: " . $e->getMessage();
            }
            ?>
            
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <?php foreach ($success as $msg): ?>
                    <div class="success"><?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>
                
                <div class="info" style="margin-top: 20px;">
                    <p><strong>Installation completed successfully!</strong></p>
                    <p><strong>Default Admin Credentials:</strong></p>
                    <ul>
                        <li>Username: <code>admin</code></li>
                        <li>Password: <code>admin123</code></li>
                        <li>Email: <code>admin@dakic-cms.com</code></li>
                    </ul>
                    <p><strong>Important:</strong> Please change the default password after first login!</p>
                </div>
                
                <a href="../../auth/login" class="btn">Go to Login Page</a>
                <a href="?step=1" class="btn" style="background: #6c757d;">Run Again</a>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</body>
</html>
