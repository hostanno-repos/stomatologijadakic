<?php
/**
 * Web-based Content Import Script
 * Automatically extracts and imports existing texts from frontend files
 * Example: http://localhost/dakic_cms/admin/database/import_contents_web.php
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Only allow in development (remove or secure this in production)
$allowed = true; // Set to false in production

if (!$allowed && php_sapi_name() !== 'cli') {
    die('Import disabled. Please run from command line.');
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
$imported = 0;
$step = $_GET['step'] ?? '1';

// Define content mappings - page => array of key => default value
$contentMappings = [
    'header' => [
        'address' => 'Nikole Tesle 23/4, 76300 Bijeljina',
        'email' => 'info@stomatologijadakic.com',
        'phone' => '+387 66 096 666',
        'working_hours' => 'Pon-Pet 9:00-18:00 / Sub-Ned - ZATVORENO',
        'menu_home' => 'Početna',
        'menu_about' => 'O nama',
        'menu_services' => 'Usluge',
        'menu_gallery' => 'Galerija',
        'menu_news' => 'Novosti',
        'menu_contact' => 'Kontakt'
    ],
    'footer' => [
        'address' => 'Nikole Tesle 23/4, 76300 Bijeljina',
        'email' => 'info@stomatologijadakic.com',
        'phone' => '+387 66 096 666',
        'phone_emergency' => '+387 66 096 666',
        'phone_orders' => '+387 66 096 666',
        'working_hours_weekdays' => 'Pon-Pet: 8:00-19:00',
        'working_hours_saturday' => 'Subotom: 8:00-13:00',
        'working_hours_sunday' => 'Nedjeljom: Samo hitni slučajevi.',
        'about_title' => 'O nama',
        'services_title' => 'Naše usluge',
        'hours_title' => 'Radno vrijeme',
        'copyright' => 'Stomatologija Dakić © ' . date('Y') . '. All Rights Reserved.'
    ],
    'sidemenu' => [
        'address' => 'Nikole Tesle 23/4, 76300 Bijeljina',
        'email' => 'info@stomatologijadakic.com',
        'phone' => '+387 66 096 666',
        'working_hours' => 'Pon-Pet 9:00-18:00 <br> Sub-Ned - ZATVORENO',
        'description' => 'Provjerite zašto smo najbolja stomatološka ordinacija u gradu!'
    ],
    'index' => [
        'cta_text' => 'Rezervišite svoj termin online',
        'cta_subtext' => 'Trebate hitnu rezervaciju? Pozovite nas na',
        'cta_phone' => '+387 66 096 666',
        'cta_button' => 'Rezervišite termin',
        'box1_title' => 'Super lokacija',
        'box1_text' => 'Nalazimo se u samom centru grada, posjedujemo svoj parking i caffe bar.',
        'box2_title' => 'Odlična usluga',
        'box2_text' => 'Mi brinemo o svakom pacijentu, Vaše zadovoljstvo je naš uspjeh.',
        'box3_title' => 'Vrhunski stručnjaci',
        'box3_text' => 'Zapošljavamo samo vrhunske stručnjake stomatologije.',
        'about_section_title' => 'O NAMA',
        'about_main_title' => 'Dobrodošli u Stomatološku ambulantu "Dakić" u Bijeljini',
        'about_description' => 'Nudimo vrhunske uluge iz svih oblasti stomatologije, te u svakom pogledu idemo u korak s vremenom. Uvjerite se i sami.',
        'about_stats_number' => '4500+',
        'about_stats_text' => 'Zadovoljnih osmjeha',
        'about_stats_subtext' => 'Uvjerite se u kvalitetu naših usluga.',
        'about_button' => 'Pogledajte naše uslue',
        'services_section_title' => 'NAJBOLJE USLUGE',
        'services_main_title' => 'Nudimo najbolje usluge iz svih oblasti stomatologije.',
        'services_description' => 'Stomatologija "Dakić" nudi široku lepezu usluga iz svih oblasti stomatologije, a pored tog vodimo brigu o svakom našem pacijentu. Uvjerite se u kvalitetu naših usluga!',
        'services_list_item' => 'Kod nas nikad nećete dva puta rješavati isti problem. Mi radimo detaljno i temeljno.',
        'team_section_title' => 'NAŠI STOMATOLOZI',
        'team_main_title' => 'Upoznajte naše zaposlene',
        'team_description' => 'Stomatologija "Dakić" je tim vrhunskih stručnjaka iz svih oblasti stomatologije. Tu smo da Vaš osmjeh učinimo blistavim.',
        'team_member_description' => 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.',
        'booking_section_title' => 'Naručite se online',
        'booking_main_title' => 'Rezervišite svoj termin',
        'booking_description' => 'Pošaljite nam dan i vrijeme kada želite da budete naručeni, a mi ćemo Vas kontaktirati što prije da Vam potvrdimo Vašp termin.'
    ],
    'kontakt' => [
        'page_title' => 'Kontakt',
        'box1_title' => 'Odlična lokacija',
        'box1_text' => 'Nalazimo se u samom centru grada, posjedujemo svoj parking i caffe bar.',
        'box2_title' => 'Sve vrste usluga',
        'box2_text' => 'Mi brinemo o svakom pacijentu, Vaše zadovoljstvo je naš uspjeh.',
        'box3_title' => 'Vrhunski stručnjaci',
        'box3_text' => 'Zapošljavamo samo vrhunske stručnjake stomatologije.',
        'contact_address' => 'Nikole Tesle 23/4, 76300 Bijeljina',
        'contact_email' => 'info@stomatologijadakic.com',
        'contact_hours_weekdays' => 'Pon-Pet: 8:00-19:00 / Sub: 8:00-13:00',
        'contact_hours_sunday' => 'Nedjeljom - Samo hitni slučajevi',
        'contact_phone' => '+387 66 096 666',
        'form_title' => 'REZERVIŠITE ONLINE',
        'form_subtitle' => 'Zatražite termin',
        'form_description' => 'Unesite svoje podatke i poruku kako biste nas kontaktirali.',
        'form_success' => 'Gotovo! Vaša poruka je poslana.',
        'form_error' => 'Žao nam je! Došlo je do greške prilikom slanja Vaše poruke.',
        'form_name_placeholder' => 'Vaše ime',
        'form_phone_placeholder' => 'Broj telefona',
        'form_email_placeholder' => 'E-mail adresa',
        'form_service_placeholder' => 'Usluga',
        'form_message_placeholder' => 'Detalji usluge koju želite',
        'form_submit' => 'Pošalji'
    ],
    'galerija' => [
        'page_title' => 'Galerija',
        'intro_title' => 'Naša ordinacija kroz slike',
        'intro_text' => 'Galerija je osmišljena tako da Vam prikaže mali dio prijatne atmosfere koja Vas čeka u našoj ordinaciji. Postanite i vi dio velikog broja pacijenata koji sa osmjehom na licu dolaze u našu ordinaciju.',
        'back_to_albums' => 'Nazad na albume',
        'no_images' => 'Nema slika ili video fajlova u ovoj galeriji.',
        'no_galleries' => 'Trenutno nema dostupnih galerija.',
        'view_album' => 'Pogledaj album',
        'images_count' => 'slika',
        'offer_section_title' => 'SPECIJALNA PONUDA',
        'offer_main_title' => 'Izdvojena ponuda dostupna svim našim pacijentima',
        'offer_description' => 'Svaki novi pacijent u našim prostorijama može obaviti BESPLATAN pregled kao i konsultacije sa našim timom u slučaju da Vam treba bilo kakava intervencija.',
        'offer_item1' => 'BESPLATAN detaljni pregled',
        'offer_item2' => 'BESPLATNE konsultacije',
        'offer_item3' => 'BESPLATNI sajveti',
        'offer_item4' => 'ČEKAMO VAS!',
        'cta_text' => 'Rezervišite svoj termin',
        'cta_subtext' => 'Trebate hitnu intervenciju? Pozovite',
        'cta_phone' => '+387 66 096 666',
        'cta_button' => 'Rezervišite termin'
    ],
    'novosti' => [
        'page_title' => 'Novosti',
        'cta_text' => 'Rezervišite svoj termin',
        'cta_subtext' => 'Trebate hitnu intervenciju? Pozovite',
        'cta_phone' => '+387 66 096 666',
        'cta_button' => 'Rezervišite termin'
    ],
    'onama' => [
        'page_title' => 'O nama',
        'main_title' => 'Dobrodošli na službenu stranicu Stomatologije Dakić',
        'description' => 'Stomatološka ordinacija Dr Dakić osnovana je 2015. godine, a nalazi se u ulici Nikole Tesle 23/4 u Bijeljini.',
        'stats_number' => '10000+',
        'stats_text' => 'Blistavih osmijeha',
        'services_intro' => 'Uz upotrebu najsavremenijih metoda i materijala u našoj ordinaciji vršimo usluge iz sledećih oblasti stomatologije:',
        'closing_text' => 'Od momenta kada prvi put pređete naš prag budite sigurni da se ste na putu potpunog oporavka i trajnog rešavanja svih zubnih problema.',
        'team_section_title' => 'NAŠI STOMATOLOZI',
        'team_main_title' => 'Upoznajte naš tim',
        'team_description' => 'Stomatologija "Dakić" je tim vrhunskih stručnjaka iz svih oblasti stomatologije. Tu smo da Vaš osmjeh učinimo blistavim.',
        'team_member_description' => 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.'
    ],
    'sidemenu' => [
        'description' => 'Provjerite zašto smo najbolja stomatološka ordinacija u gradu!',
        'contact_title' => 'Kontakt',
        'address' => 'Nikole Tesle 23/4, 76300 Bijeljina',
        'email' => 'info@stomatologijadakic.com',
        'working_hours' => 'Pon-Pet 9:00-18:00 <br> Sub-Ned - ZATVORENO',
        'phone' => '+387 66 096 666',
        'book_button' => 'Zakažite termin',
        'follow_title' => 'Pratite nas'
    ]
];

?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Contents - Dakic CMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Import Sadržaja</h1>
        
        <?php if ($step === '1'): ?>
            <div class="info">
                <p><strong>Pre nego što počnete:</strong></p>
                <ul>
                    <li>Proverite da li MySQL/MariaDB radi</li>
                    <li>Tabela <code>contents</code> mora već postojati (pokrenite <code>install_contents_web.php</code> prvo)</li>
                    <li>Ovo će automatski uneti postojeće tekstove sa frontend sajta u CMS</li>
                </ul>
            </div>
            
            <div class="warning">
                <p><strong>Napomena:</strong> Ako sadržaj već postoji, biće ažuriran. Ako ne postoji, biće kreiran.</p>
            </div>
            
            <div style="margin-top: 20px;">
                <h3>Sadržaji koji će biti uveženi:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Stranica</th>
                            <th>Broj polja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contentMappings as $page => $fields): ?>
                            <tr>
                                <td><strong><?php echo ucfirst($page); ?></strong></td>
                                <td><?php echo count($fields); ?> polja</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <a href="?step=2" class="btn btn-primary">Uvezi sadržaje</a>
            
        <?php elseif ($step === '2'): ?>
            <?php
            try {
                // Connect to database
                $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Check if contents table exists
                $stmt = $pdo->query("SHOW TABLES LIKE 'contents'");
                if ($stmt->rowCount() === 0) {
                    $errors[] = "Tabela contents ne postoji. Molimo pokrenite install_contents_web.php prvo.";
                } else {
                    $success[] = "Tabela contents pronađena. Počinjem sa uvozom...";
                    
                    // Import each page's contents
                    foreach ($contentMappings as $page => $fields) {
                        foreach ($fields as $keyName => $defaultValue) {
                            try {
                                // Check if content exists
                                $stmt = $pdo->prepare("SELECT id FROM contents WHERE page = ? AND key_name = ? LIMIT 1");
                                $stmt->execute([$page, $keyName]);
                                $existing = $stmt->fetch();
                                
                                if ($existing) {
                                    // Update existing
                                    $stmt = $pdo->prepare("
                                        UPDATE contents 
                                        SET value = ?, updated_at = NOW() 
                                        WHERE id = ?
                                    ");
                                    $stmt->execute([$defaultValue, $existing['id']]);
                                } else {
                                    // Create new
                                    $stmt = $pdo->prepare("
                                        INSERT INTO contents (page, key_name, value, description, created_at, updated_at) 
                                        VALUES (?, ?, ?, ?, NOW(), NOW())
                                    ");
                                    $description = ucfirst(str_replace('_', ' ', $keyName));
                                    $stmt->execute([$page, $keyName, $defaultValue, $description]);
                                }
                                
                                $imported++;
                            } catch (PDOException $e) {
                                $errors[] = "Greška pri uvozu {$page}/{$keyName}: " . $e->getMessage();
                            }
                        }
                    }
                    
                    if ($imported > 0) {
                        $success[] = "Uspešno uvezeno {$imported} sadržaja!";
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
                    <p><strong>Uvoz je uspešno završen!</strong></p>
                    <p>Uvezeno je <strong><?php echo $imported; ?></strong> sadržaja za sledeće stranice:</p>
                    <ul>
                        <?php foreach ($contentMappings as $page => $fields): ?>
                            <li><strong><?php echo ucfirst($page); ?></strong> - <?php echo count($fields); ?> polja</li>
                        <?php endforeach; ?>
                    </ul>
                    <p>Sada možete ići u sekciju Sadržaji u admin panelu i menjati sve tekstove.</p>
                </div>
                
                <a href="../../contents" class="btn btn-primary">Idi na Sadržaje</a>
                <a href="?step=1" class="btn" style="background: #6c757d;">Pokreni ponovo</a>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</body>
</html>
