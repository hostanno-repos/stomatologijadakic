<?php
/**
 * Instalacija tabele site_images (slike na sajtu – zamjena putem admina).
 * Pristup: .../admin/database/install_site_images_web.php
 */
$allowed = true;
if (!$allowed && php_sapi_name() !== 'cli') {
    die('Installation disabled.');
}

define('ADMIN_PATH', dirname(__DIR__));
define('BASE_PATH', dirname(ADMIN_PATH));

require_once ADMIN_PATH . '/config/config.php';
$dbHost = DB_HOST;
$dbName = DB_NAME;
$dbUser = DB_USER;
$dbPass = DB_PASS;

$errors = [];
$success = [];
$step = $_GET['step'] ?? '1';
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalacija – Slike na sajtu</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .btn { display: inline-block; padding: 10px 20px; background: #556ee6; color: white; text-decoration: none; border-radius: 4px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Slike na sajtu – instalacija tabele</h1>
        <?php if ($step === '1'): ?>
            <div class="info">
                <p>Kreira se tabela <code>site_images</code> za zamjenu slika putem admin panela.</p>
                <a href="?step=2" class="btn">Pokreni instalaciju</a>
            </div>
        <?php else: ?>
            <?php
            try {
                $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "
                CREATE TABLE IF NOT EXISTS `site_images` (
                  `key` varchar(100) NOT NULL,
                  `path` varchar(500) DEFAULT NULL,
                  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`key`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ";
                $pdo->exec($sql);
                $success[] = "Tabela site_images je kreirana.";
            } catch (PDOException $e) {
                $errors[] = "Greška: " . $e->getMessage();
            }
            ?>
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $err): ?>
                    <div class="error"><?php echo htmlspecialchars($err); ?></div>
                <?php endforeach; ?>
                <a href="?step=1" class="btn">Pokušaj ponovo</a>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <?php foreach ($success as $msg): ?>
                    <div class="success"><?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>
                <a href="<?php echo defined('ADMIN_URL') ? ADMIN_URL : ''; ?>/site-images" class="btn">Idi na Slike na sajtu</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
