<?php
/**
 * Web-based Employees Table Installation
 * Pristup: http://localhost/stomatologijadakic.com/admin/database/install_employees_web.php
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
    <title>Instalacija tabele zaposleni</title>
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
        <h1>Instalacija tabele zaposleni</h1>
        <?php if ($step === '1'): ?>
            <div class="info">
                <p>Ovaj skript kreira tabelu <code>employees</code> (ime, prezime, pozicija, opis, slika, pol za avatar).</p>
                <a href="?step=2" class="btn">Pokreni instalaciju</a>
            </div>
        <?php else: ?>
            <?php
            try {
                $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "
                CREATE TABLE IF NOT EXISTS `employees` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `first_name` varchar(100) NOT NULL,
                  `last_name` varchar(100) NOT NULL,
                  `position` varchar(255) NOT NULL,
                  `description` text DEFAULT NULL,
                  `image` varchar(500) DEFAULT NULL,
                  `gender` enum('male','female') NOT NULL DEFAULT 'male',
                  `sort_order` int(11) DEFAULT 0,
                  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  KEY `sort_order` (`sort_order`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ";
                $pdo->exec($sql);
                $success[] = "Tabela employees je uspešno kreirana ili već postoji.";

                // Ažuriraj postojeću tabelu: dodaj image i gender ako nedostaju
                $cols = $pdo->query("SHOW COLUMNS FROM employees")->fetchAll(PDO::FETCH_COLUMN);
                if (!in_array('image', $cols)) {
                    $pdo->exec("ALTER TABLE employees ADD COLUMN image varchar(500) DEFAULT NULL AFTER description");
                    $success[] = "Dodata kolona image.";
                }
                if (!in_array('gender', $cols)) {
                    $pdo->exec("ALTER TABLE employees ADD COLUMN gender enum('male','female') NOT NULL DEFAULT 'male' AFTER image");
                    $success[] = "Dodata kolona gender.";
                }
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
                <a href="<?php echo ADMIN_URL ?? ''; ?>/employees" class="btn">Idi na Zaposlene</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
