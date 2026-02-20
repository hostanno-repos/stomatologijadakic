<?php
/**
 * Database Installation Script
 * Run this file once to set up the database and create default admin user
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Security: Only allow running from command line or localhost in development
if (php_sapi_name() !== 'cli' && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die('This script can only be run from localhost or command line');
}

define('ADMIN_PATH', dirname(__DIR__));
define('BASE_PATH', dirname(ADMIN_PATH));

// Database credentials
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'dakic_cms';

echo "Setting up database...\n";

try {
    // Connect to MySQL server (without database)
    $pdo = new PDO("mysql:host={$dbHost};charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    echo "Creating database '{$dbName}'...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created successfully.\n\n";
    
    // Select database
    $pdo->exec("USE `{$dbName}`");
    
    // Read and execute SQL file
    $sqlFile = ADMIN_PATH . '/database/setup.sql';
    if (file_exists($sqlFile)) {
        echo "Reading SQL file...\n";
        $sql = file_get_contents($sqlFile);
        
        // Split by semicolon and execute each statement
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        
        foreach ($statements as $statement) {
            if (!empty($statement) && !preg_match('/^(--|CREATE DATABASE|USE)/i', $statement)) {
                try {
                    $pdo->exec($statement);
                } catch (PDOException $e) {
                    // Ignore "table already exists" errors
                    if (strpos($e->getMessage(), 'already exists') === false) {
                        echo "Warning: " . $e->getMessage() . "\n";
                    }
                }
            }
        }
        
        echo "Tables created successfully.\n\n";
    }
    
    // Create default admin user if it doesn't exist
    echo "Setting up default admin user...\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = 'admin'");
    $stmt->execute();
    $userExists = $stmt->fetchColumn() > 0;
    
    if (!$userExists) {
        // Default password: admin123
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
        
        echo "Default admin user created:\n";
        echo "  Username: admin\n";
        echo "  Password: admin123\n";
        echo "  Email: admin@dakic-cms.com\n\n";
    } else {
        echo "Admin user already exists.\n\n";
    }
    
    echo "Database setup completed successfully!\n";
    echo "You can now access the admin panel at: http://localhost/dakic_cms/admin\n";
    echo "Login with: admin / admin123\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
