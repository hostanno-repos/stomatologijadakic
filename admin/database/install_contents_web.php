<?php
/**
 * Web-based Contents Table Installation Script
 * Access this file through your browser to set up contents table
 * Example: http://localhost/dakic_cms/admin/database/install_contents_web.php
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
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contents Table Installation - Dakic CMS</title>
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
        <h1>Contents Table Installation</h1>
        
        <?php if ($step === '1'): ?>
            <div class="info">
                <p><strong>Pre nego što počnete:</strong></p>
                <ul>
                    <li>Proverite da li MySQL/MariaDB radi</li>
                    <li>Kredencijali baze: Host: <code><?php echo $dbHost; ?></code>, Korisnik: <code><?php echo $dbUser; ?></code></li>
                    <li>Baza <code><?php echo $dbName; ?></code> mora već postojati</li>
                    <li>Tabela <code>users</code> mora već postojati (pokrenite <code>install_web.php</code> prvo ako je potrebno)</li>
                    <li>Ovo će kreirati tabelu <code>contents</code> za upravljanje svim tekstovima na frontendu</li>
                </ul>
            </div>
            
            <div class="warning">
                <p><strong>Napomena:</strong> Ako tabela već postoji, neće biti prepisana. Ovaj skript koristi <code>CREATE TABLE IF NOT EXISTS</code>.</p>
            </div>
            
            <a href="?step=2" class="btn btn-primary">Kreiraj Contents tabelu</a>
            
        <?php elseif ($step === '2'): ?>
            <?php
            try {
                // Connect to database
                $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Check if users table exists
                $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
                if ($stmt->rowCount() === 0) {
                    $errors[] = "Tabela users ne postoji. Molimo pokrenite install_web.php prvo da kreirate users tabelu.";
                } else {
                    $success[] = "Tabela users pronađena. Nastavljam sa kreiranjem contents tabele.";
                    
                    // Create contents table
                    $createContentsTableSQL = "
                    CREATE TABLE IF NOT EXISTS `contents` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `page` varchar(100) NOT NULL,
                      `key_name` varchar(100) NOT NULL,
                      `value` text NOT NULL,
                      `description` varchar(255) DEFAULT NULL,
                      `created_by` int(11) DEFAULT NULL,
                      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                      `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `unique_content` (`page`, `key_name`),
                      KEY `page` (`page`),
                      KEY `created_by` (`created_by`),
                      CONSTRAINT `fk_contents_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                    ";
                    
                    $pdo->exec($createContentsTableSQL);
                    $success[] = "Tabela contents je uspešno kreirana.";
                    
                    // Verify table was created
                    $stmt = $pdo->query("SHOW TABLES LIKE 'contents'");
                    $contentsExists = $stmt->rowCount() > 0;
                    
                    if ($contentsExists) {
                        $success[] = "Tabela je uspešno verifikovana!";
                        
                    // Check table structure
                    $stmt = $pdo->query("DESCRIBE contents");
                    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    $success[] = "Tabela sadrži " . count($columns) . " kolona: " . implode(', ', $columns);
                    
                    $success[] = "Nakon kreiranja tabele, pokrenite <a href='import_contents_web.php' style='color: #556ee6;'>import_contents_web.php</a> da uvezete postojeće tekstove.";
                    }
                }
                
            } catch (PDOException $e) {
                $errors[] = "Greška: " . $e->getMessage();
            }
            ?>
            
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
                
                <a href="?step=1" class="btn">Pokušaj ponovo</a>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <?php foreach ($success as $msg): ?>
                    <div class="success"><?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>
                
                <div class="info" style="margin-top: 20px;">
                    <p><strong>Instalacija je uspešno završena!</strong></p>
                    <p>Kreirana je sledeća tabela:</p>
                    <ul>
                        <li><code>contents</code> - Čuva sve tekstove sa frontend sajta organizovane po stranicama i segmentima</li>
                    </ul>
                    <p>Sada možete koristiti sekciju Sadržaji u admin panelu.</p>
                </div>
                
                <a href="../../contents" class="btn btn-primary">Idi na Sadržaje</a>
                <a href="?step=1" class="btn" style="background: #6c757d;">Pokreni ponovo</a>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</body>
</html>
